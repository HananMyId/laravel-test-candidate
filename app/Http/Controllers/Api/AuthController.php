<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required'
            ]);
            if ($validator->fails()) throw new \Exception('Please insert username & password.', 400);

            $credentials['email'] = $request->email;
            $credentials['password'] = $request->password;
            if (!Auth::attempt($credentials)) throw new \Exception('Unauthorized.', 401);

            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('authToken')->accessToken;
            return response()->json([
                'status_code' => 200,
                'status_message' => 'User logged in successfully.',
                'data' => [
                    'token' => $token
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => $e->getCode(),
                'status_message' => $e->getMessage()
            ], $this->responseErrorCode($e->getCode()));
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'status_code' => 200,
            'message' => 'Token deleted successfully!'
        ]);
    }
}
