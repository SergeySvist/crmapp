<?php

namespace App\Models;

class Worker extends \Core\Orm\Model
{
    const WORKER_STATUS_INACTIVE = 0;
    const WORKER_STATUS_ACTIVE = 1;
    protected string $table = 'workers';
    protected array $fillable = [
        'first_name', 'last_name', 'phone', 'status', 'salary',
    ];
    protected array $fields = [
        'id', 'first_name', 'last_name', 'phone', 'status', 'salary',
    ];
}
