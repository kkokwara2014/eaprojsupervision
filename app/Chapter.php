<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Project;
use App\Comment;

class Chapter extends Model
{
    protected $fillable=['title','project_id','filename'];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function scores(){
        return $this->hasMany(Score::class);
    }
}
