<?php

namespace App\Models\admin;

use App\Models\admin\Blog;
use App\Models\admin\CommentBlogReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentBlog extends Model
{
    use HasFactory;

    protected $table = 'blog_comments';

    protected $guarded = ['id'];

    public function reply(){
        return $this->hasMany(CommentBlogReply::class, 'comment_id', 'id');
    }

    public function blog(){
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
}
