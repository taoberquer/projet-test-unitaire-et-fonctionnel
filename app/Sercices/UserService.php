<?php


namespace App\Sercices;


use App\Models\User;
use Carbon\Carbon;

class UserService
{
    public function isValid(User $user): array
    {
        return $user->isValid();
    }
}
