<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id',
        'transaction_id',
        'amount',
        'asigment_id',
    ];
}
