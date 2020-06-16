<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['asigment_id', 'teacher_id'];

    protected $dates = ['created_at', 'updated_at'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function asigment()
    {
        return $this->belongsTo(Asigment::class)->with(
            'level',
            'category',
            'files'
        );
    }
}
