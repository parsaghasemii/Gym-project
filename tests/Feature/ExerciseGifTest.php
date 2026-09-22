<?php

namespace Tests\Feature;

use App\Enums\Equipment;
use App\Enums\FitnessLevel;
use App\Enums\Gender;
use App\Enums\Goal;
use App\Models\Exercise;
use App\Models\MuscleGroup;
use App\Models\User;
use App\Models\UserProfile;
use App\Services\ProgramGenerator;
use Database\Seeders\ExerciseSeeder;
use Database\Seeders\MealSeeder;
use Database\Seeders\MuscleGroupSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExerciseGifTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        Http::fake([
            'https://raw.githubusercontent.com/*' => Http::response('[]'),
            'https://static.exercisedb.dev/media/*' => Http::response($this->minimalGifContents(), 200, ['Content-Type' => 'image/gif']),
            'https://pub-585d42eb1aa64a67aedf483ec328d3fe.r2.dev/*' => Http::response($this->minimalVideoContents(), 200, ['Content-Type' => 'video/mp4']),
        ]);

        $this->seed([
            MuscleGroupSeeder::class,
            ExerciseSeeder::class,
            MealSeeder::class,
        ]);
    }

    public function test_admin_can_upload_gif_when_creating_exercise(): void
    {
        $admin = User::factory()->admin()->create();
        $muscleGroup = MuscleGroup::query()->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.exercises.store'), [
                'name' => 'حرکت با GIF',
                'muscle_group_id' => $muscleGroup->id,
                'equipment' => 'full_gym',
                'difficulty' => 'beginner',
                'default_sets' => 3,
                'default_reps' => '10',
                'rest_seconds' => 60,
                'gif' => UploadedFile::fake()->createWithContent(
                    'demo.gif',
                    $this->minimalGifContents(),
                ),
            ])
            ->assertRedirect(route('admin.exercises.index'));

        $exercise = Exercise::query()->where('name', 'حرکت با GIF')->firstOrFail();

        $this->assertNotNull($exercise->gif_path);
        Storage::disk('public')->assertExists($exercise->gif_path);
    }

    public function test_program_page_shows_gif_controls_only_when_exercise_has_gif(): void
    {
        Exercise::query()->update(['gif_path' => null]);

        $user = $this->memberWithProgram();
        $exercise = $user->activeProgram
            ->load('days.exercises.exercise')
            ->days
            ->flatMap->exercises
            ->first()
            ->exercise;

        $responseWithoutGif = $this->actingAs($user)
            ->get(route('program.show'))
            ->assertOk();

        $this->assertDoesNotMatchRegularExpression(
            '/<button[^>]*@click="[^"]*open-exercise-gif/',
            $responseWithoutGif->getContent(),
        );

        $path = 'exercises/demo.gif';
        Storage::disk('public')->put($path, $this->minimalGifContents());
        $exercise->update(['gif_path' => $path]);

        $responseWithGif = $this->actingAs($user)
            ->get(route('program.show'))
            ->assertOk()
            ->assertSee('demo.gif', false)
            ->assertSee($exercise->name);

        preg_match(
            '/<button[^>]*x-data[^>]*@click="[^"]*open-exercise-gif[^"]*"[^>]*>/',
            $responseWithGif->getContent(),
            $thumbButton,
        );

        $this->assertNotEmpty($thumbButton, 'Expected an Alpine-enabled GIF thumb button on the program page.');
        $this->assertStringContainsString('<img', $responseWithGif->getContent());
        $this->assertStringContainsString('open-exercise-gif', $responseWithGif->getContent());
        $this->assertStringContainsString('exercise-gif-lightbox__close-bar', $responseWithGif->getContent());
        $this->assertStringContainsString('بستن', $responseWithGif->getContent());
    }

    private function memberWithProgram(): User
    {
        $user = User::factory()->create(['onboarding_completed' => true]);

        UserProfile::query()->create([
            'user_id' => $user->id,
            'age' => 28,
            'gender' => Gender::Male,
            'height' => 175,
            'weight' => 78,
            'fitness_level' => FitnessLevel::Intermediate,
            'goal' => Goal::MuscleGain,
            'days_per_week' => 4,
            'equipment' => Equipment::FullGym,
        ]);

        $user->muscleFocus()->sync(
            MuscleGroup::query()->whereIn('slug', ['chest', 'back'])->pluck('id'),
        );

        app(ProgramGenerator::class)->generate($user->fresh(['profile', 'muscleFocus']));

        return $user->fresh();
    }

    private function minimalGifContents(): string
    {
        return base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');
    }

    private function minimalVideoContents(): string
    {
        return base64_decode('AAAAFGZ0eXBpc29tAAACAGlzb21pc28yYXZjMW1wNDEAAAAIZnJlZQAA');
    }
}
