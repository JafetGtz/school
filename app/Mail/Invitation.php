<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Asigment;

class Invitation extends Mailable
{
    use Queueable, SerializesModels;

    protected $asigment;

    public function __construct(Asigment $asigment)
    {
        $this->asigment = $asigment;
    }

    public function build()
    {
        return $this->markdown('mails.invitation')->with([
            'url' => route('invitation.show', $this->asigment->id),
        ]);
    }
}
