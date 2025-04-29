<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['follower_id', 'followed_id'];

    /**
     * Get the user who is following
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    /**
     * Get the user being followed
     */
    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
