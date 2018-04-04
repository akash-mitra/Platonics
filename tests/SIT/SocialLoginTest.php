<?php
namespace Tests\SIT;

use Mockery;
use App\User;
use Tests\TestCase;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginTest extends TestCase
{
    protected $user;


    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }



    public function test_google_auth_callback_logs_in_new_user()
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');

        $abstractUser->shouldReceive('getId')
            ->andReturn(rand())
            ->shouldReceive('getName')
            ->andReturn(str_random(10))
            ->shouldReceive('getEmail')
            ->andReturn(str_random(10) . '@gmail.com')
            ->shouldReceive('getAvatar')
            ->andReturn('https://en.gravatar.com/userimage');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');

        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $this->get('/auth/google/callback')->assertSee($abstractUser->getName());
    }
}
