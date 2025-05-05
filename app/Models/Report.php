<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['user_id', 'reportable_id', 'reportable_type', 'reason', 'status'];

    // Pelapor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reportable()
    {
        return $this->morphTo();
    }

    // Optional helper methods
    public function isForStory()
    {
        return $this->reportable_type === Story::class;
    }

    public function isForComment()
    {
        return $this->reportable_type === Comment::class;
    }
}
