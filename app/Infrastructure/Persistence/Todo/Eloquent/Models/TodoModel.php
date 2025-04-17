<?php

namespace App\Infrastructure\Persistence\Todo\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TodoModel extends Model
{
    use HasUuids;

    protected $table = 'todos';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'completed',
    ];

    protected $casts = [
        'completed'  => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
