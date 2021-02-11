<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UserControllerTest extends TestCase
{
    public function testUserCreation()
    {
        $response = $this->call('POST', '/user', [
            'firstname' => 'Tao',
            'lastname' => 'BERQUER',
            'password' => Str::random(),
            'email' => 'tao.berquer@gmail.com',
            'birthday' => Carbon::now()->subYears(20)
        ]);

        $this->assertEquals(201, $response->status());
    }

    public function testUserNotCreate()
    {
        $response = $this->call('POST', '/user', [
            'firstname' => 'Tao',
            'lastname' => 'BERQUER',
            'password' => Str::random(),
            'email' => Str::random(),
            'birthday' => Carbon::now()->subYears(20)
        ]);

        $this->assertEquals(404, $response->status());
    }

    public function testUserFound()
    {
        $user = User::create([
            'firstname' => 'Tao',
            'lastname' => 'BERQUER',
            'password' => Str::random(),
            'email' => 'tao.berquer@gmail.com',
            'birthday' => Carbon::now()->subYears(20)
        ]);

        $response = $this->call('GET', '/user/' . $user->id);

        $this->assertEquals(200, $response->status());
    }

    public function testUserNotFound()
    {
        $response = $this->call('GET', '/user/45');

        $this->assertEquals(404, $response->status());
    }
}
