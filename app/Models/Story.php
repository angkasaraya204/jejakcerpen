<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'user_id',
        'category_id',
        'anonymous',
        'status',
    ];

    protected $casts = [
        'anonymous' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function userVote()
    {
        return $this->hasOne(Vote::class)->where('user_id', auth()->id());
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

    public function views()
    {
        return $this->hasMany(Views::class);
    }
}
