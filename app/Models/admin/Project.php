<?php

namespace App\Models\admin;

use App\Models\admin\KategoriProject;
use App\Models\admin\KomentarProject;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\KomentarProjectReply;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'project';

    protected $guarded = ['id'];

    // relasi
    public function kategori_project(){
        return $this->belongsTo(KategoriProject::class, 'kategori_project_id');
    }

    public function komentar_project(){
        return $this->hasMany(KomentarProject::class, 'project_id', 'id');
    }

    public function komentar_project_reply(){
        return $this->hasMany(KomentarProjectReply::class, 'project_id', 'id');
    }
}
