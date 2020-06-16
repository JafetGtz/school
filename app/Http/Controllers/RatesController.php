<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatesController extends Controller
{
    public function index($id)
    {
        return view()->component(
            'rate',
            ['title' => 'Puntuar clase'],
            [
                'teacher' => \App\Teacher::findOrFail($id),
                'criterias' => \DB::table('criterias')->get(),
            ]
        );
    }

    public function create($id)
    {
        return \DB::table('rates')->insert(request()->rates);
    }
}
