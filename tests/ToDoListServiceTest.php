<?php

namespace Tests\AppBundle\Service;

use App\Models\Item;
use App\Models\ToDoList;
use App\Models\User;
use App\Sercices\ToDoListService;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

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
            'birthday' => Carbon::now(),
        ]);

        $this->toDoList = $this->user->toDoList()->create([
            'name' => 'La todoux',
            'description' => 'los descriptor'
        ]);

        $this->item = $this->toDoList()->items()->create([
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
        $this->expectException(\Exception::class);
        (new ToDoListService())->create($this->user, "Ma première ToDoList", "Une superbe ToDoList");
    }

    public function testToDoListAlreadyExist()
    {
        $this->expectException(Exception::class);
        (new ToDoListService())->create($this->user, "La todoux", "los descriptor");
    }

    public function testAddItemWithoutError()
    {
        $fakeItem = new Item([
            'name' => 'dd',
            'content' => 'ezfze'
        ]);
        (new ToDoListService())->addItem($this->toDoList, $fakeItem);

        $this->assertContains($fakeItem, $this->toDoList->items());
    }

    public function testIsToDoListValid() {
        $this->assertEmpty((new ToDoListService())->isValid($this->toDoList));
    }

    public function testRemoveElements() {
        $this->toDoList->items()->delete();

        if ($this->toDoList->items())

        $this->assertEmpty($this->toDoList->items);
    }
}
