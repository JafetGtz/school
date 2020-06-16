<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;
use Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showResetForm(Request $request, $token = null)
    {
        return view()->component(
            'auth.passwords.reset',
            ['title' => 'Renovar contraseña'],
            [
                'token' => $token,
                'email' => $request->email,
            ]
        );
    }
    
    public function resetPassword(Request $request){
        $email = request()->input('email');
        $user = User::where("email", "=", $email)->first();

        if(request()->input('password')!=request()->input('password_confirmation')){
            return "Las contraseñas no son iguales.";
        }
        else if(strlen((request()->input('password'))) < 6){
            return "La contraseña debe contener al menos 6 caracteres.";
        }
        else{
            $user->password = Hash::make(request()->input('password'));
            $user->save(); 
            return "pass";
        }
    }


}
