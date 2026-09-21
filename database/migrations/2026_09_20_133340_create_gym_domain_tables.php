<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('gender')->nullable();
            $table->decimal('height', 5, 1)->nullable();
            $table->decimal('weight', 5, 1)->nullable();
            $table->string('fitness_level')->nullable();
            $table->string('goal')->nullable();
            $table->unsignedTinyInteger('days_per_week')->nullable();
            $table->string('equipment')->nullable();
            $table->text('injuries')->nullable();
            $table->timestamps();
        });

        Schema::create('muscle_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('user_muscle_focus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('muscle_group_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'muscle_group_id']);
        });

        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('muscle_group_id')->constrained()->cascadeOnDelete();
            $table->string('equipment');
            $table->string('difficulty');
            $table->unsignedTinyInteger('default_sets')->default(3);
            $table->string('default_reps')->default('8-12');
            $table->unsignedSmallInteger('rest_seconds')->default(90);
            $table->timestamps();
        });

        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('meal_type');
            $table->unsignedSmallInteger('calories');
            $table->unsignedSmallInteger('protein');
            $table->unsignedSmallInteger('carbs');
            $table->unsignedSmallInteger('fat');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('starts_at');
            $table->date('ends_at');
            $table->string('status')->default('active');
            $table->string('split_type');
            $table->timestamps();
        });

        Schema::create('program_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day_number');
            $table->string('day_name');
            $table->string('focus_label');
            $table->timestamps();
        });

        Schema::create('program_day_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_day_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('sets');
            $table->string('reps');
            $table->unsignedSmallInteger('rest_seconds');
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('program_nutrition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->unique()->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('daily_calories');
            $table->unsignedSmallInteger('protein');
            $table->unsignedSmallInteger('carbs');
            $table->unsignedSmallInteger('fat');
            $table->timestamps();
        });

        Schema::create('program_day_meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_day_id')->constrained()->cascadeOnDelete();
            $table->foreignId('meal_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_day_meals');
        Schema::dropIfExists('program_nutrition');
        Schema::dropIfExists('program_day_exercises');
        Schema::dropIfExists('program_days');
        Schema::dropIfExists('programs');
        Schema::dropIfExists('meals');
        Schema::dropIfExists('exercises');
        Schema::dropIfExists('user_muscle_focus');
        Schema::dropIfExists('muscle_groups');
        Schema::dropIfExists('user_profiles');
    }
};
