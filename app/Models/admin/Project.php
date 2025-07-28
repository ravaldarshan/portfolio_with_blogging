<?php

namespace App\Models\admin;

use App\Models\admin\CategoryProject;
use App\Models\admin\CommentProject;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\CommentProjectReply;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project';

    protected $guarded = ['id'];

    // relasi
    public function category_project(){
        return $this->belongsTo(CategoryProject::class, 'category_project_id');
    }

    public function comment_project(){
        return $this->hasMany(CommentProject::class, 'project_id', 'id');
    }

    public function comment_project_reply(){
        return $this->hasMany(CommentProjectReply::class, 'project_id', 'id');
    }
}
