<?php

namespace Database\Factories;

use App\Enums\QuestionSelectionEnum;
use App\Enums\TestVisibilityEnum;
use App\Models\Test;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TestFactory extends Factory
{
    protected $model = Test::class;

    public function definition()
    {
        $now = Carbon::now();
        $images = [
            'Laravel' => 'https://picperf.io/https://laravelnews.s3.amazonaws.com/images/laravel-featured.png',
            'Vue' => 'https://s3.amazonaws.com/angularminds.com/new-blog-images/top-10-features-of-vuejs-for-web-apps.svg',
            'Figma' => 'https://lagrandeourse.design/wp-content/uploads/2021/03/Comment-faire-un-prototype-sur-Figma-_.jpg',
            'React' => 'https://letecode.com/storage/articles/September2021/fKFlgB6K1b9IwjcgwtGl.png',
            'Express' => 'https://miro.medium.com/v2/resize:fit:1400/1*i2fRBk3GsYLeUk_Rh7AzHw.png'
        ];
        $title = $this->faker->randomElement(['Laravel', 'Vue', 'Figma', 'React', 'Express']);

        $thumbnail = '';
        if ($title === 'Laravel') {
            $thumbnail = $images['Laravel'];
        } elseif ($title === 'Vue') {
            $thumbnail = $images['Vue'];
        } elseif ($title === 'Figma') {
            $thumbnail = $images['Figma'];
        } elseif ($title === 'React') {
            $thumbnail = $images['React'];
        } else {
            $thumbnail = $images['Express'];
        }
        $userId = User::first()->id;
        return [
            'id' => $this->faker->unique()->numberBetween(1, 10),
            'title' => $title,
            'description' => Str::limit($this->faker->paragraph, 155),
            'thumbnail' => $thumbnail,
            'duration' => $this->faker->numberBetween(60, 120),
            'passing_score' => $this->faker->numberBetween(50, 100),
            'question_selection' => $this->faker->randomElement(QuestionSelectionEnum::values()),
            'questions_number' => $this->faker->numberBetween(5, 10),
            'allowed_attempts_number' => $this->faker->numberBetween(1, 3),
            'window_allowed_crossing_duration' => $this->faker->numberBetween(2, 30),
            'window_crossing_penalties_number' => $this->faker->numberBetween(2, 5),
            'visibility' => $this->faker->randomElement(TestVisibilityEnum::values()),
            'require_access_code' => $this->faker->boolean,
            'is_camera_required' => $this->faker->boolean,
            'is_audio_required' => $this->faker->boolean,
            'created_by_user_id' => $userId,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
