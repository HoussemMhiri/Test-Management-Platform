<?php

namespace Tests\Feature\Auth;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageApiAuthenticationTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    /** @test */
    public function user_can_log_in_if_the_submited_credentials_are_correct()
    {
        $this->updateLocale('foo');

        $user = UserFactory::new()->create();

        $response = $this->postJson(route('api.login'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertOk()
          ->assertJsonPath('data.user.name', $user->name)
          ->assertJsonPath('data.user.email', $user->email)
          ->assertJsonPath('data.user.is_admin', $user->is_admin)
          ->assertJsonPath('success', true);

        $this->assertNotNull($response['data']['token']);
    }

    /** @test */
    public function it_validates_that_email_is_a_valid_email_while_logging()
    {
        $this->updateLocale('foo');

        $user = userFactory::new()->create(['email' => 'cokitana@gmail.com']);

        $this->postJson(route('api.login'), [
            'email' => 'NOT A VALID EMAIL',
            'password' => 'password',
        ])->assertInvalid([
            'email' => 'validation.email',
        ]);
    }

    /** @test */
    public function it_validates_that_email_exists_in_database_while_logging()
    {
        $this->updateLocale('foo');

        $this->postJson(route('api.login'), [
            'email' => 'email_dont_exist@gmail.com',
            'password' => 'password',
        ])->assertInvalid([
            'email' => 'validation.exists',
        ]);
    }

    /** @test */
    public function user_can_logout_if_access_token_is_correct()
    {
        $this->updateLocale('foo');

        $user = $this->signInSanctum();

        $this->assertEquals(1, $user->tokens()->count());

        $this->postJson(route('api.logout'))
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertEquals(0, $user->tokens()->count());
    }
}
