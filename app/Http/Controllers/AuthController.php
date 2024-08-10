<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    // register
    public function register(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:4'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Failed',
                    'error' => $validator->errors()
                ], 422);
            }

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Registration Completed'
                // 'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // login
    public function login(Request $request)
    {
        // try {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:4'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Failed',
                    'error' => $validator->errors()
                ], 422);
            }

            $credentials = $request->only(['email', 'password']);

            if (Auth::attempt($credentials)) {
                $user = User::findOrFail(Auth::id());
                // $user = User::where('email', $request->email)->first();
                return response()->json([
                    'success' => true,
                    'message' => 'Logged in successfully',
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials'
            ], 401);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Internal Server Error',
        //         'error' => $e->getMessage()
        //     ], 500);
        // }
    }

    public function user()
    {
        try {

            $user = Auth::user();

            return response()->json([
                'success' => true,
                'message' => 'User Fetch success',
                'data' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        $user = User::findOrFail(Auth::id());

        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ], 200);
    }
}
