<?php


namespace App\Services;


use App\Models\Item;
use App\Models\ToDoList;
use App\Models\User;
use Tests\AppBundle\Service\ItemServiceTest;

class ToDoListService
{
    public function create(User $user, string $name, string $description)
    {
        (new UserService())->isValid($user);

        if ($user->toDoList)
            throw new \Exception('User seems to already have a ToDoList');

        return $user->toDoList()->create([
            'name' => $name,
            'description' => $description
        ]);
    }

    public function addItem(ToDoList $toDoList, Item $item)
    {
        (new ItemService())->isValid($item);

        if (! $this->isTimeEnough());
            throw new \Exception('Sorry there is not enough time past');

        if (! $this->isToDoListFull())
            throw new \Exception('Sorry no more space in you TODO List');

        $toDoList->items()->create($item);
    }

    public function removeItem(Item $item)
    {
        $item->delete();
    }

    public function isValid(ToDoList $toDoList): void
    {
        if (empty($toDoList->getName()))
            throw new \Exception('Name is missing');

        if (empty($toDoList->getDescription()))
            throw new \Exception('Description is missing');
    }

    public function isTimeEnough(ToDoList $toDoList): bool
    {
        $minimumTimePast = Carbon::instance($toDoList->items()->first()->createdAt())->addMinutes(30);

        return Carbon::now()->isBefore($minimumTimePast);
    }

    public function isToDoListFull(ToDoList $toDoList): bool
    {
        return $toDoList->itemsCount() === 10;
    }
}
