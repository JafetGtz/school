<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Bill extends Mailable
{
    use Queueable, SerializesModels;

    protected $bill;

    public function __construct($bill)
    {
        $this->bill = [
            'payer' => $bill['payer'],
            'invoice_number' => $bill['invoice_number'],
            'items' => $bill['items'],
            'currency' => $bill['currency'],
            'subtotal' => $bill['subtotal'],
            'total' => $bill['total'],
        ];
    }

    public function build()
    {
        return $this->view('mails.bill')->with($this->bill);
    }
}
