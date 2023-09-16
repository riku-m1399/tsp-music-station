<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post';
    protected $fillable = ['category_id', 'post_id'];
    public $timestamps = false;

    # to get the name of the categories
    public function category(){
        return $this->belongsTo (Category::class);
    }

    # to get the info of the post
    public function post(){
        return $this->belongsTo (Post::class);
    }
}
