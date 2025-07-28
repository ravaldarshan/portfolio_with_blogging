<?php

namespace App\Models\admin;

use App\Models\admin\Project;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\CommentProjectReply;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentProject extends Model
{
    use HasFactory;

    protected $table = 'comment_project';

    protected $guarded = ['id'];

    public function reply(){
        return $this->hasMany(CommentProjectReply::class, 'comment_id', 'id');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
