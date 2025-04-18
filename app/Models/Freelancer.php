<?php

namespace Fickrr\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Freelancer extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $guard = 'freelancer';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}