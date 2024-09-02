<?php

namespace Tests\Unit;

use App\Enums\GenderEnum;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test*/
    public function scratch()
    {
        $user = UserFactory::new()->create(['last_name' => "mallek", 'first_name' => 'ayoub']);

        $user->password = "123";

    }
}
