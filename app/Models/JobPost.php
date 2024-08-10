<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'company',
        'location',
        'salary'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function applicants()
    {
        return $this->belongsToMany(User::class, 'job_applications', 'job_post_id', 'applicant_id')->withPivot('resume')->withTimestamps();
    }
}
