<?php

namespace App\Http\Controllers;

use App\Components\UserComponent;
use App\Http\Requests\CreateTokenRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = app(UserComponent::class)->store($request);

        $success['token'] = $user->createToken($user->name)->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, __('User register successfully.'));
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = app(UserComponent::class)->login($request);

        if($user) {
            $success['token'] = $request->user()->createToken($user->name);
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');

        } else {

        }
    }

    public function createToken(CreateTokenRequest $request)
    {
        $user = app(UserComponent::class)->findUserWithPassword($request);

        if(!$user) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

        return $user->createToken($user->name)->plainTextToken;
    }
}
