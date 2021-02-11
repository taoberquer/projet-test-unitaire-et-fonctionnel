<?php


namespace Feature;


use App\Models\ToDoList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ItemControllerTest extends \TestCase
{
    protected ToDoList $toDoList;

    public function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::create([
            'firstname' => 'Tao',
            'lastname' => 'BERQUER',
            'password' => Str::random(),
            'email' => 'tao.berquer@gmail.com',
            'birthday' => Carbon::now()->subYears(20)
        ]);

        $this->toDoList = $user->toDoList()->create([
            'name' => Str::random(),
            'description' => Str::random(100)
        ]);
    }

    public function testToDoListItemCreation()
    {
        $response = $this->call('POST', '/todolist/' . $this->toDoList->id . '/item/', [
            'name' => Str::random(),
            'description' => Str::random(100)
        ]);

        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testToDoListCreationParamsMissing()
    {
        $response = $this->call('POST', '/todolist/' . $this->toDoList->id . '/item/', [
            'description' => Str::random(100)
        ]);

        $this->assertEquals(404, $response->getStatusCode());

        $response = $this->call('POST', '/todolist/' . $this->toDoList->id . '/item/', [
            'name' => Str::random(),
        ]);

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testToDoListItemCreationWithWrongLenghtDescription()
    {
        $response = $this->call('POST', '/todolist/' . $this->toDoList->id . '/item/', [
            'name' => Str::random(),
            'description' => Str::random(1005)
        ]);

        $this->assertEquals(404, $response->getStatusCode());
    }
}
