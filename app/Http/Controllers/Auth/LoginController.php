<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
//use App\Providers\RouteServiceProvider;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\School;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'school'    => ['required'],
            'email'     => ['required', 'email'],
            'password'  => ['required'],
        ]);

        $school     = $credentials['school'];
        $email      = $credentials['email'];
        $password   = $credentials['password'];

        if (Auth::attempt(['email' => $email, 'password' => $password, 'school_id' => $school])) {
             $request->session()->regenerate();
             if(auth()->user()->role == 'student'){
                $request->session()->put('student_id', auth()->user()->id);
             }
             return redirect()->intended('home');
        }

        return back()->withErrors([
            'email' => 'Las credenciales provistas no fueron encontradas.',
        ]);


    }  

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('/');
    }  


    public function ShowLoginForm(){
        $school = School::all();
        $data = [];
        $data['schools'] = $school; 
        return view('auth.login',$data);
    } 
}
