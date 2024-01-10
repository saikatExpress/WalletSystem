<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_name',
        'project_logo',
        'status',
        'flag',
    ];

    protected $casts = [
        'id'           => 'integer',
        'project_name' => 'string',
        'project_logo' => 'string',
        'status'       => 'string',
        'flag'         => 'integer',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];
}
