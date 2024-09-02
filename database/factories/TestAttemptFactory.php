<?php

namespace Database\Factories;

use App\Enums\UserTestAttemptResultEnum;
use App\Models\TestSession;
use App\Models\User;
use App\Models\UserTestAttempt;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestAttemptFactory extends Factory
{
    protected $model = UserTestAttempt::class;

    public function definition()
    {
        $testSessionId = TestSession::inRandomOrder()->first()->id;
        $startAt = TestSession::find($testSessionId)->start_at;
        $endAt = TestSession::find($testSessionId)->end_at;
        $userId = User::inRandomOrder()->first()->id;
        return [
            'id' => fake()->unique()->numberBetween(1, 30),
            'user_id' =>  $userId,
            'test_session_id' => $testSessionId,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'result' => fake()->randomElement(UserTestAttemptResultEnum::values()),
            'recorded_camera_video_path' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'recorded_audio_path' => $this->faker->regexify('[A-Za-z0-9]{10}'),
        ];
    }
}
