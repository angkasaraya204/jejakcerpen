<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Views extends Model
{
    use HasFactory;

    protected $table = 'stories_views';

    protected $fillable = [
        'story_id',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship ke Story
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    // Relationship ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
