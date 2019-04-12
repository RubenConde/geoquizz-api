<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return $this->sendError('There was an error!', $errors, 400);
        }

        $request['password'] = Hash::make($request['password']);
        $user = User::create($request->toArray());

        $token = $user->createToken('prealluded nonvenomously')->accessToken;
        $response = ['token' => $token];

        return $this->sendResponse($response, 'Registration completed successfully');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('prealluded nonvenomously')->accessToken;
                $response = ['token' => $token];
                return $this->sendResponse($response, 'Logged successfully');
            } else {
                $response = "Password missmatch";
                return $this->sendError($response, [], 422);
            }
        } else {
            $response = 'User does not exist';
            return $this->sendError($response, [], 422);
        }
    }

    public function logout(Request $request)
    {

        $token = $request->user()->token();
        $token->revoke();

        $response = 'You have been successfully logged out!';
        return $this->sendResponse('', $response);

    }
}
