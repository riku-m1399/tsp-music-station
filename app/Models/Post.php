<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Post extends Model
{
    use HasFactory;

    // a post belongs to a user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // To get the categories under a post
    // hasMany --> 1 to many
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

    // To get the comments under a post
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    // To get the likes of a post
    public function likes(){
        return $this->hasMany(Like::class);
    }

    // To check if the AUTH user liked the post
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }
}
