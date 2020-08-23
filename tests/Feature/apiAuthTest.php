<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\DataUserModel;
use App\Models\DataExpenseModel;

class apiAuthTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected $user;
    protected $accessToken;

    public function setUp():void {
        parent::setUp();

        $this->user = factory(DataUserModel::class)->create();

        $this->actingAs($this->user);
        $this->artisan("passport:install");

        $tokenResult        = $this->user->createToken('Personal Access Token');
        $token              = $tokenResult->token;
        $token->save();

        $this->accessToken = $tokenResult->accessToken;
    }

    //register 401 eg didn't pass the security key
    public function test_auth_register_login_403()
    {
        $data = [
            //Don't forget the key else you will get 401
        ];

        $this->post(route('register'), $data)
                ->assertStatus(403);

        $this->post(route('login'), $data)
                ->assertStatus(403);
    }

    //registering a user
    public function test_auth_register()
    {
        $data = [
            'name'              => $this->faker->name,
            'email'             => $this->faker->unique()->safeEmail,
            'password'          => Hash::make("password"),
            'key'               => "password" //this should be unique but for test purpose i just used pasword. Don't forget this else you will get 401
        ];

        $this->post(route('register'), $data)
                ->assertStatus(201)
                ->assertJsonStructure(['name','email','created_at','updated_at']);
    }

    //login test
    public function test_auth_login()
    {
        $data = [
            'email'             => $this->user->email,
            'password'          => "password",
            'key'               => "password" //this should be unique but for test purpose i just used pasword. Don't forget this else you will get 401
        ];

        $this->post(route('login'), $data)
                ->assertStatus(200);
    }

    //logout test
    public function test_auth_logout()
    {
        $this->get(route('logout'), ['Authorization' => 'Bearer ' . $this->accessToken])
                ->assertStatus(200);
    }
}
