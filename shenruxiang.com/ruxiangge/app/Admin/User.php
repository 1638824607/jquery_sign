<?php

namespace App\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //
    use Notifiable;

    protected $table = "users";

    protected $guarded = [
        ''
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
