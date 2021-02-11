<?php


namespace App\Services;


use App\Models\User;
use Carbon\Carbon;

class UserService
{
    public function isValid(User $user): void
    {
        if (! filter_var($this->email, FILTER_VALIDATE_EMAIL))
            throw new \Exception('Incorrect email');

        if (strlen($this->uncrypted_password) < 8 || strlen($this->uncrypted_password) > 40)
            throw new \Exception('Incorrect password');

        if (empty($this->lastname))
            throw new \Exception('Lastname is missing');

        if (empty($this->firstname))
            throw new \Exception('Firstname is missing');

        if (! $this->birthday->addYears('13')->isBefore(Carbon::now()))
            throw new \Exception('Incorrect age');
    }
}
