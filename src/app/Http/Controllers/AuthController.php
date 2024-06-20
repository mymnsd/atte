<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AutherReequest;
use App\Models\User;

class AuthController extends Controller
{
    public function getLogin(){
        return view('index');
    }

    public function postLogin(AutherRequest $request){
        $email = $request->email;
        $password = $request->password;
        return view('index');
    }

    // public function postLogout(Request $request){
    //     User::logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect('auth.login');
    // }
    
    
}
