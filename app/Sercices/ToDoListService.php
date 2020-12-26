<?php


namespace App\Sercices;


use App\Models\Item;
use App\Models\ToDoList;
use App\Models\User;
use Tests\AppBundle\Service\ItemServiceTest;

class ToDoListService
{
    public function create(User $user, string $name, string $description)
    {
        if ((new UserService())->isValid($user) !== [])
            throw new \Exception('User seems not valid !');

        if ($user->toDoList)
            throw new \Exception('User seems to already have a ToDoList');

        return $user->toDoList()->create([
            'name' => $name,
            'description' => $description
        ]);
    }

    public function addItem(ToDoList $toDoList, Item $item)
    {
        if ((new ItemService())->isValid($item) !== [])
            throw new \Exception('Item seems not valid !');

        if (! $this->isTimeEnough());
            throw new \Exception('Sorry there is not enough time past');

        if (! $this->isToDoListFull())
            throw new \Exception('Sorry no more space in you TODO List');

        $toDoList->items()->create($item);
    }

    public function removeItem(ToDoList $todoList, Item $item)
    {
        $item->delete();
    }

    public function isValid(ToDoList $toDoList)
    {
        $toReturn = [];

        if (empty($toDoList->getName()))
            $toReturn[] = 'Name is missing';

        if (empty($toDoList->getDescription()))
            $toReturn[] = 'Description is missing';

        return $toReturn;
    }

    public function isTimeEnough(ToDoList $toDoList)
    {
        $minimumTimePast = Carbon::instance($toDoList->items()->first()->createdAt())->addMinutes(30);

        return Carbon::now()->isBefore($minimumTimePast);
    }

    public function isToDoListFull(ToDoList $toDoList)
    {
        return count($toDoList->items) === 10;
    }
}
