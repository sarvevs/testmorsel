<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::check()){
            return redirect()->intended(route('products.index'));

        }
        $data = $request->only(['email', 'password']);

        if (Auth::attempt($data)){
            return redirect()->intended(route('products.index'));
        }
        return redirect(route('user.login'))->withErrors([
            'email' => 'Ошибка'
        ]);
    }
}
