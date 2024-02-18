<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'price',
        'type',
        'message',
        'status',
        'flag',
    ];

    protected $casts = [
        'id'         => 'integer',
        'image'      => 'string',
        'name'       => 'string',
        'price'      => 'string',
        'type'       => 'string',
        'message'    => 'string',
        'status'     => 'string',
        'flag'       => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}