<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'excerpt',
        'author',
        'post_date',
        'image'
    ];

    public function getImageUrlAttribute()
    {

        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('images/' . $this->image);
    }

    // Local Scope: lấy bài viết của user có ID = 2
    public function scopeCuaUser2($query)
    {
        return $query->where('user_id', 2);
    }

    public function categories()
    {
        return $this->belongsTo('Categories', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}