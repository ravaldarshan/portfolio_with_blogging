<?php

namespace App\Models\admin;

use App\Models\admin\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentBlogReply extends Model
{
    use HasFactory;

    protected $table = 'blog_comments_reply';

    protected $guarded = ['id'];
    
    public function blog(){
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
}
