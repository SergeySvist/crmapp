<?php

namespace App\Models;

use Core\Orm\Model;

class User extends Model
{
    protected string $table = 'users';
    protected array $fillable = [
        'username', 'email', 'password', 'token'
    ];
    protected array $fields = [
        'id', 'username', 'email', 'password', 'token'
    ];
}
