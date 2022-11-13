<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create(RegisterRequest $request)
    {
        if (Auth::check()){
            return redirect(route('products.index'));
        }

        $data = $request->validated();
        if (User::where('email', $data['email'])->exists()){
            return redirect(route('user.register'))->withErrors([
                'email' => 'Уже зарегистрирован'
            ]);
        }
        $user = User::create($data);


        if($user){
           Auth::login($user);
           return redirect(route('products.index'));
        }
        return redirect(route('user.login'))->withErrors([
            'formError' => 'Ошибка'
        ]);


    }
}
