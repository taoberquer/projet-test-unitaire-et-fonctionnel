<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ToDoListControllerTest extends TestCase
{
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'firstname' => 'Tao',
            'lastname' => 'BERQUER',
            'password' => Str::random(),
            'email' => 'tao.berquer@gmail.com',
            'birthday' => Carbon::now()->subYears(20)
        ]);
    }

    public function testToDoListCreation()
    {
        $response = $this->call('POST', '/user/' . $this->user->id . '/todolist/', [
            'name' => Str::random(),
            'description' => Str::random(100)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testToDoListCreationUserNotFound()
    {
        $response = $this->call('POST', '/user/45/todolist/', [
            'name' => Str::random(),
            'description' => Str::random(100)
        ]);

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testToDoListCreationParamsMissing()
    {
        $response = $this->call('POST', '/user/' . $this->user->id . '/todolist/', [
            'description' => Str::random(100)
        ]);

        $this->assertEquals(404, $response->getStatusCode());

        $response = $this->call('POST', '/user/' . $this->user->id . '/todolist/', [
            'name' => Str::random(),
        ]);

        $this->assertEquals(404, $response->getStatusCode());
    }
}
