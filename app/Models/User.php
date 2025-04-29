<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Users that are following this user
     */
    public function followers()
    {
        return $this->hasMany(Follow::class, 'followed_id');
    }

    /**
     * Users that this user is following
     */
    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    /**
     * Check if this user is following another user
     *
     * @param int $userId
     * @return bool
     */
    public function isFollowing($userId)
    {
        return $this->following()->where('followed_id', $userId)->exists();
    }

    /**
     * Check if this user is followed by another user
     *
     * @param int $userId
     * @return bool
     */
    public function isFollowedBy($userId)
    {
        return $this->followers()->where('follower_id', $userId)->exists();
    }
}
