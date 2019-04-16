<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    public $timestamps = true;

    const IS_COMPLETED = 1;
    const INPROGRESS = 0;

    public function tasks() {
        return $this->hasMany('App\Task', 'project_id', 'id');
    }
}
