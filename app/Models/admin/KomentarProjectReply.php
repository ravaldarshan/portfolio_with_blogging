<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarProjectReply extends Model
{
    use HasFactory;

    protected $table = 'komentar_project_reply';

    protected $guarded = ['id'];
    
    public function project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
