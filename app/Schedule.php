<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public $timestamps = false;

    protected $fillable = ['start', 'end', 'day_of_week', 'teacher_id'];
}
