<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;


class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function confirmEmail(Request $request, $token)
    {
        User::whereToken($token)->firstOrFail()->confirmEmail();

        $request->session()->flash('message', 'Учетная запись подтверждена. Войдите под своим именем.');

        return redirect('login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $user = User::create($request->all());

        Mail::to($user)->send(new UserRegistered($user));

        $request->session()->flash('message', 'На ваш адрес было выслано письмо с подтверждением регистрации.');

        return redirect()->back();
    }
}
