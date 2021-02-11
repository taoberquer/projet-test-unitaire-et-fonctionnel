<?php


namespace App\Http\Controllers;


use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    public function create(Request $request): JsonResponse
    {
        $this->validate($request, [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'password' => 'required|string|min:9|max:39',
            'email' => 'required|email',
            'birthday' => 'required|date'
        ]);

        $user = new User([
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'password' => $request->get('password'),
            'email' => $request->get('email'),
            'birthday' => $request->get('birthday'),
        ]);

        $errors = (new UserService())->isValid($user);

        if ($errors !== [])
            return response()->json(['errors' => $errors], 400);

        $user->save();

        return response()->json([], 201);
    }

    public function show(int $userID)
    {
        /** @var User $user */
        $user = User::find($userID);

        if ($user === null)
            return response()->json(['error' => 'Cannot find user'], 404);

        return response()->json($user);
    }

    public function delete(int $userID)
    {
        /** @var User $user */
        $user = User::find($userID);

        if ($user === null)
            return response()->json(['error' => 'Cannot find user'], 404);

        $user->delete();

        return response()->json();
    }
}
