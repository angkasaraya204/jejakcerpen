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
     * Get users that this user follows
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')
            ->withTimestamps();
    }

    /**
     * Get users that follow this user
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Check if user follows another user
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('followed_id', $user->id)->exists();
    }
}
