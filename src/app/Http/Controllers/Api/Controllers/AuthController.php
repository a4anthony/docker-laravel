<?php

namespace App\Http\Controllers\Api\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public $successStatus = 200;

    public function index()
    {
        return User::all();
    }
    public function show($userId)
    {
        return User::find($userId);
    }
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            //$success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => 'User details match our records', 'user_id' => $user->id], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $request->token = substr(str_shuffle($permitted_chars), 0, 60);
        $validator = Validator::make(
            $request->all(),
            [
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'regex:/(0)[0-9]{10}/'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (User::where('token', $request->token)->exists()) {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            // Output: 54esmdr0qf
            $uniquetoken = substr(str_shuffle($permitted_chars), 0, 60);
        } else {
            $uniquetoken = $request->token;
        }
        User::create(
            [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'token' => $uniquetoken,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]
        );


        $user = User::where('email',  $request->email)->first();
       // $success = "User registered successfully.";


        return response()->json(
            [
                'success' => $user->toArray(),
            ]
        );
        // return response()->json(['success' => $success, 'user_id' => $userId], $this->successStatus);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
