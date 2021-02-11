<?php

use App\Models\Item;
use App\Models\ToDoList;
use App\Models\User;
use App\Services\ToDoListService;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ToDoListServiceTest extends TestCase
{
    protected User $user;

    protected ToDoList $toDoList;

    protected Item $item;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'firstname' => 'Remi',
            'lastname' => 'BRAT',
            'email' => 'rbrat@gmail.com',
            'uncrypted_password' => 'lesupermotdepasse',
            'birthday' => Carbon::now()->subYears(20),
        ]);

        $this->toDoList = $this->user->toDoList()->create([
            'name' => Str::random(),
            'description' => 'los descriptor'
        ]);

        $this->item = $this->toDoList->items()->create([
            'name' => 'Le premier item',
            'content' => 'Ceci est du contenu'
        ]);
    }

    public function testCreateValidToDoList()
    {
        $this->user->toDoList()->first()->delete();
        $this->assertInstanceOf(
            ToDoList::class,
            (new ToDoListService())->create($this->user, "Ma première ToDoList", "Une superbe ToDoList")
        );
    }

    public function testCreateToDoListUserNotValid()
    {
        $this->user->birthday = Carbon::now();
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Incorrect age');
        (new ToDoListService())->create($this->user, "Ma première ToDoList", "Une superbe ToDoList");
    }

    public function testToDoListAlreadyExist()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('User seems to already have a ToDoList');
        (new ToDoListService())->create($this->user, "La todoux", "los descriptor");
    }

    public function testAddItemWithoutError()
    {
        $fakeItem = new Item([
            'name' => Str::random(),
            'content' => Str::random()
        ]);
        $toDolistService = new ToDoListService();
        $toDolistService->addItem($this->toDoList, $fakeItem);

        $this->assertContains(
            Item::where('name', $fakeItem->name)->first()->toArray(),
            $this->toDoList->items->toArray()
        );
    }

    public function testIsToDoListValid() {
        $this->assertEmpty((new ToDoListService())->isValid($this->toDoList));
    }
}
