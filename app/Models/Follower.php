<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follower_id'
    ];

    public function follower()
    {
        return $this->hasOne(User::class, 'id', 'follower_id');
    }

    public function followed()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
