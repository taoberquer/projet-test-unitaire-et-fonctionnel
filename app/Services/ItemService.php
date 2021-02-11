<?php


namespace App\Services;


use App\Models\Item;

class ItemService
{
    public function isNameUnique(Item $item): bool
    {
        return Item::where('name', $item->name)->first() !== false;
    }

    public function isValid(Item $item): void
    {
        if (empty($item->getName()))
            throw new \Exception('Name is missing');

        if (! $this->isNameUnique($item))
            throw new \Exception('Name already use');

        if (empty($item->getContent()))
            throw new \Exception('Content already use');

        if (strlen($item->getContent()) > 1000)
            throw new \Exception('Content is over 1 000 char');
    }
}
