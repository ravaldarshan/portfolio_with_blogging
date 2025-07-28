<?php

namespace App\Models\admin;

use App\Models\admin\CategoryBlog;
use App\Models\admin\CommentBlog;
use App\Models\admin\CommentBlogReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'blog';

    protected $guarded = ['id'];

    // relasi
    public function category(){
        return $this->belongsTo(CategoryBlog::class, 'category_id');
    }
    
    public function blog_comments(){
        return $this->hasMany(CommentBlog::class, 'blog_id', 'id');
    }
    
    public function blog_comments_reply(){
        return $this->hasMany(CommentBlogReply::class, 'blog_id', 'id');
    }
}
