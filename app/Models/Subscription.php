<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'flag',
        'isActive',
    ];

    protected $casts = [
        'id'         => 'integer',
        'user_id'    => 'integer',
        'status'     => 'integer',
        'flag'       => 'integer',
        'isActive'   => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relation Start
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
