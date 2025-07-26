<?php

namespace App\Models\admin;

use App\Models\admin\Project;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\KomentarProjectReply;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomentarProject extends Model
{
    use HasFactory;

    protected $table = 'komentar_project';

    protected $guarded = ['id'];

    public function reply(){
        return $this->hasMany(KomentarProjectReply::class, 'komentar_id', 'id');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
