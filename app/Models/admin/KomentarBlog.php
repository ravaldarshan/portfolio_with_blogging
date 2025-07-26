<?php

namespace App\Models\admin;

use App\Models\admin\Blog;
use App\Models\admin\KomentarBlogReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomentarBlog extends Model
{
    use HasFactory;

    protected $table = 'komentar_blog';

    protected $guarded = ['id'];

    public function reply(){
        return $this->hasMany(KomentarBlogReply::class, 'komentar_id', 'id');
    }

    public function blog(){
        return $this->belongsTo(Blog::class, 'blog_id', 'id');
    }
}
