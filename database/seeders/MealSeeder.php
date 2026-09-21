<?php

namespace Database\Seeders;

use App\Enums\MealType;
use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    public function run(): void
    {
        Meal::query()
            ->where('name', 'ساندwich مرغ و سبزی')
            ->update(['name' => 'ساندویچ مرغ و سبزی']);

        $meals = [
            ['name' => 'املت پنیر و سبزی', 'meal_type' => MealType::Breakfast, 'calories' => 350, 'protein' => 22, 'carbs' => 12, 'fat' => 24, 'description' => '۲ تخم‌مرغ، پنیر لیقوان، گوجه و فلفل'],
            ['name' => 'جو دوسر با موز', 'meal_type' => MealType::Breakfast, 'calories' => 420, 'protein' => 15, 'carbs' => 65, 'fat' => 12, 'description' => 'جو دوسر، موز، شیر کم‌چرب'],
            ['name' => 'نان سنگک با پنیر و گردو', 'meal_type' => MealType::Breakfast, 'calories' => 380, 'protein' => 18, 'carbs' => 40, 'fat' => 16, 'description' => 'نان سنگک، پنیر، گردو'],
            ['name' => 'ماست یونانی با عسل', 'meal_type' => MealType::Breakfast, 'calories' => 280, 'protein' => 20, 'carbs' => 30, 'fat' => 8, 'description' => 'ماست یونانی، عسل، تخمه'],
            ['name' => 'چای سبز و خرما', 'meal_type' => MealType::Snack, 'calories' => 120, 'protein' => 1, 'carbs' => 30, 'fat' => 0, 'description' => '۳ عدد خرما'],

            ['name' => 'زرشک پلو با مرغ', 'meal_type' => MealType::Lunch, 'calories' => 650, 'protein' => 45, 'carbs' => 70, 'fat' => 18, 'description' => 'برنج، سینه مرغ، زرشک'],
            ['name' => 'خوراک لوبیا با برنج', 'meal_type' => MealType::Lunch, 'calories' => 520, 'protein' => 22, 'carbs' => 75, 'fat' => 12, 'description' => 'لوبیا قرمز، برنج، سالاد'],
            ['name' => 'ساندویچ مرغ و سبزی', 'meal_type' => MealType::Lunch, 'calories' => 480, 'protein' => 35, 'carbs' => 45, 'fat' => 16, 'description' => 'نان سبوس‌دار، سینه مرغ، کاهو'],
            ['name' => 'عدس پلو', 'meal_type' => MealType::Lunch, 'calories' => 580, 'protein' => 25, 'carbs' => 80, 'fat' => 14, 'description' => 'عدس، برنج، کشمش و پیاز داغ'],
            ['name' => 'سالاد مرغ', 'meal_type' => MealType::Lunch, 'calories' => 420, 'protein' => 38, 'carbs' => 20, 'fat' => 20, 'description' => 'کاهو، سینه مرغ، زیتون، سس ماست'],

            ['name' => 'خورشت قیمه با برنج', 'meal_type' => MealType::Dinner, 'calories' => 620, 'protein' => 30, 'carbs' => 68, 'fat' => 22, 'description' => 'گوشت چرخ‌کرده، لپه، برنج'],
            ['name' => 'ماهی کبابی با سبزی', 'meal_type' => MealType::Dinner, 'calories' => 450, 'protein' => 42, 'carbs' => 15, 'fat' => 24, 'description' => 'فیله ماهی، سبزیجات بخارپز'],
            ['name' => 'املت سبزیجات', 'meal_type' => MealType::Dinner, 'calories' => 320, 'protein' => 24, 'carbs' => 10, 'fat' => 20, 'description' => '۳ تخم‌مرغ، قارچ، فلفل'],
            ['name' => 'سوپ جو و مرغ', 'meal_type' => MealType::Dinner, 'calories' => 380, 'protein' => 28, 'carbs' => 40, 'fat' => 10, 'description' => 'جو، مرغ ریش‌شده، هویج'],
            ['name' => 'پاستا با سس گوجه و مرغ', 'meal_type' => MealType::Dinner, 'calories' => 550, 'protein' => 32, 'carbs' => 72, 'fat' => 14, 'description' => 'پاستا، سینه مرغ، سس گوجه'],

            ['name' => 'شیر و موز', 'meal_type' => MealType::Snack, 'calories' => 200, 'protein' => 8, 'carbs' => 32, 'fat' => 4, 'description' => 'شیر کم‌چرب، یک موز'],
            ['name' => 'آجیل مخلوط', 'meal_type' => MealType::Snack, 'calories' => 250, 'protein' => 8, 'carbs' => 12, 'fat' => 20, 'description' => 'بادام، پسته، گردو — ۳۰ گرم'],
            ['name' => 'پروتئین بار خانگی', 'meal_type' => MealType::Snack, 'calories' => 220, 'protein' => 15, 'carbs' => 25, 'fat' => 8, 'description' => 'جو، کره بادام‌زمینی، عسل'],
            ['name' => 'سیب با کره بادام‌زمینی', 'meal_type' => MealType::Snack, 'calories' => 210, 'protein' => 6, 'carbs' => 24, 'fat' => 10, 'description' => 'یک سیب، یک قاشق کره بادام‌زمینی'],
        ];

        foreach ($meals as $meal) {
            Meal::query()->updateOrCreate(
                ['name' => $meal['name']],
                [
                    ...$meal,
                    'meal_type' => $meal['meal_type']->value,
                ],
            );
        }
    }
}
