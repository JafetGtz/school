<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asigment extends Model
{
    public $guarded = ['id', 'created_at', 'updated_at'];

    protected $appends = ['formated_date', 'formated_created_at'];

    public function getFormatedDateAttribute()
    {
        $date = Carbon::parse($this->attributes['date']);

        return $date->isoFormat('D \d\e MMMM') .
            ', a las ' .
            $date->isoFormat('h:mm a');
    }

    public function getFormatedCreatedAtAttribute()
    {
        $date = Carbon::parse($this->attributes['created_at']);
        return $date->isoFormat('D \d\e MMMM');
    }


    public function depositVoucher()
    {
        return $this->hasOne(DepositVoucher::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
