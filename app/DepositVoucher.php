<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositVoucher extends Model
{
    protected $fillable = ['path'];

    public function asigment()
    {
        return $this->belongsTo(Asigment::class);
    }
}
