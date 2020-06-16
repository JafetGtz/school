<?php

namespace App\Http\Controllers;

use App\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Invitation;

class InvitationController extends Controller
{
    public function show($id)
    {
        $invitation = Invitation::findOrFail($id);

        // Do not show an invitations that was already accepted
        if ($invitation->status === 'accepted') {
            return redirect()->route('dashboard.index');
        }

        return view()->component(
            'invitation',
            ['title' => 'Invitación'],
            [
                'invitation' => $invitation,
                'asigment' => $invitation->asigment,
            ]
        );
    }

    public function update($id, int $answer)
    {
        $invitation = Invitation::findOrFail($id);
        $invitation->status = $answer ? 'accepted' : 'denied';
        $invitation->save();

        if ($answer) {
            try {
                $mail = new \App\Mail\Notification();
                Mail::to($invitation->asigment->email)->queue($mail);
            } catch (\Throwable $th) {
                report($th);
            }
        }

        return $invitation;
    }
}
