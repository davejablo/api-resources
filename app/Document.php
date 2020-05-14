<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['project_id', 'document', 'name', 'description'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
