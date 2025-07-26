<?php

namespace App\Models\admin;

use App\Models\admin\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriProject extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "kategori_project";

    protected $guarded = ['id'];

    // relasi
    public function project(){
        return $this->hasMany(Project::class, 'kategori_project_id', 'id');
    }
}
