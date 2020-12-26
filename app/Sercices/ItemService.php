<?php


namespace App\Sercices;


use App\Models\Item;

class ItemService
{
    public function isNameUnique(Item $item)
    {
        return Item::where('name', $item->name)->first() !== false;
    }

    public function isValid(Item $item)
    {
        $toReturn = [];

        if (empty($item->getName()))
            $toReturn[] = 'Name is missing';

        if (! $this->isNameUnique($item))
            $toReturn[] = 'Name already use';

        if (empty($item->getContent()))
            $toReturn[] = 'Content already use';

        if (strlen($item->getContent()) > 1000)
            $toReturn[] = 'Content is over 1 000 char';

        return $toReturn;
    }
}
