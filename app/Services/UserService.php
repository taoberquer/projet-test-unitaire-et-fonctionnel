<?php


namespace App\Services;


use App\Models\User;
use Carbon\Carbon;

class UserService
{
    public function isValid(User $user): bool
    {
        if (! filter_var($user->email, FILTER_VALIDATE_EMAIL))
            throw new \Exception('Incorrect email');

        if (strlen($user->uncrypted_password) < 8 || strlen($user->uncrypted_password) > 40)
            throw new \Exception('Incorrect password');

        if (empty($user->lastname))
            throw new \Exception('Lastname is missing');

        if (empty($user->firstname))
            throw new \Exception('Firstname is missing');

        if (! (new Carbon($user->birthday))->addYears('13')->isBefore(Carbon::now()))
            throw new \Exception('Incorrect age');

        return true;
    }
}
