<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;


class AuthenticateController extends Controller
{
    //
    public function login(){
    	return view('auth.login');
    }

    public function loginUser(LoginUserRequest $request){
        $login = Auth::attempt(['username' => $request['username'], 'password' => $request['password']]);
        if($login){
            if(Auth::user()->is_active == 1){
                return redirect('/');
            } else {
                Auth::logout();
                return redirect()->back()->with('failure', 'It seems your account is not active. Contact Administrator to active your account!');
            }
        } else{
    	    return redirect()->back()->with('failure', 'Invalid Username or Password');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
