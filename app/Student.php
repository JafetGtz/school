<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;

    public function user()
    {
        $this->morphOne(User::class, 'userable');
    }

    public function asigments()
    {
        return $this->hasMany(Asigment::class);
    }
}
