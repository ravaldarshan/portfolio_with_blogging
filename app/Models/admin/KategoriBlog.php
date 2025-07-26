<?php

namespace App\Models\admin;

use App\Models\admin\Blog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriBlog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_blog';

    protected $guarded = ['id'];

    // relasi
    public function blog(){
        return $this->hasMany(Blog::class, 'kategori_id', 'id');
    }
}
