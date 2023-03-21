<?php

namespace App\Components;

use App\Http\Requests\CreateTokenRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserComponent extends BaseComponent {

    public function store(RegisterRequest $request): User
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        return $user;
    }

    public function login(LoginRequest $request): User
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            return $user;
        }

        return false;
    }

    public function findUserWithPassword(CreateTokenRequest $request): User
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return false;
        }

        return $user;
    }
}
