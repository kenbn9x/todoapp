<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    public $timestamps = true;

    const IS_COMPLETED = 1;
    const INPROGRESS= 0;
}
