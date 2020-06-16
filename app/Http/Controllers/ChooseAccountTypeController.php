<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ChooseAccountTypeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->is('teacher') || $user->is('student') || $user->isAdmin()) {
            return redirect()->route('dashboard.index');
        }

        return view()->component('choose-account-type', [
            'title' => 'Elegir tipo de cuenta',
        ]);
    }

    public function decide()
    {
        $type = request()->input('type');
        $id = \DB::table($type . 's')->insertGetId([]);

        $user = auth()->user();
        $user->userable_type = $type;
        $user->userable_id = $id;
        $user->save();
    }
}
