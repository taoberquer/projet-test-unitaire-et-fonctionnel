<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lastname', 'firstname', 'email', 'birthday', 'uncrypted_password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function isValid(): array
    {
        $toReturn = [];

        if (! filter_var($this->email, FILTER_VALIDATE_EMAIL))
            $toReturn[] = 'Incorrect email';

        if (strlen($this->uncrypted_password) < 8 || strlen($this->uncrypted_password) > 40)
            $toReturn[] = 'Incorrect password';

        if (empty($this->lastname))
            $toReturn[] = 'Lastname is missing';

        if (empty($this->firstname))
            $toReturn[] = 'Firstname is missing';

        if (! $this->birthday->addYears('13')->isBefore(Carbon::now()))
            $toReturn[] = 'Incorrect age';

        return $toReturn;
    }
}
