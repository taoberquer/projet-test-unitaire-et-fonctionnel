<?php


namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\ToDoList;
use App\Services\ToDoListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function addItem(Request $request, int $toDoListID): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'content' => 'required|string|max:1000'
        ]);

        $toDoList = ToDoList::find($toDoListID);

        if ($toDoList === null)
            return response()->json(['error' => 'Cannot find ToDoList', 404]);

        try {
            (new ToDoListService())->addItem($toDoList, new Item([
                'name' => $request->get('name'),
                'content' => $request->get('content')
            ]));

            return response()->json([], 201);
        } catch (\Exception $exception)
        {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function removeItem(int $itemID)
    {
        $item = Item::find($itemID);

        if ($item === null)
            return response()->json(['error' => 'Cannot find Item', 404]);

        (new ToDoListService())->removeItem($item);

        return response()->json();
    }
}
