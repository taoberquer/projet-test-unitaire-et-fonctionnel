<?php


namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\ToDoList;
use App\Models\User;
use App\Services\ToDoListService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ToDoListController extends Controller
{
    public function create(Request $request, int $userID): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        $user = User::find($userID);

        if ($user === null)
            return response()->json(['error' => 'Cannot find user', 404]);

        try {
            (new ToDoListService())->create($user, $request->get('name'), $request->get('description'));

            return response()->json([], 201);
        } catch (\Exception $exception)
        {
            response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
