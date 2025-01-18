<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
//     public function show(Request $request)
//    {
//     // Manually set the session store if it's not set
//     if (!$request->hasSession()) {
//         $request->setLaravelSession(app('session.store'));
//     }

//     return response()->json(['message' => 'CSRF cookie set'])->withCookie(
//         cookie('XSRF-TOKEN', $request->session()->token())
//     );
// }

    public function registerUser(Request $request)
    {
        $data=$request->validate([
            'name'=>'required|string',
            'lastName'=>'required|string',
            'role'=>'required|string',
            'email'=>'required|email',
            'password'=>['confirmed',Password::min(6)->mixedCase()->numbers()]
        ]);
        $user=User::create([
            'name'=>$data['name'],
            'lastName'=>$data['lastName'],
            'email'=>$data['email'],
            'role'=>$data['role'],
            'password'=>$data['password']
        ]);


        return response('user Registered',200);
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
        'remember' => 'boolean',
    ]);

    $remember = $credentials['remember'] ?? false;
    unset($credentials['remember']);

    if (!Auth::attempt($credentials)) {
        return response()->json([
            'error' => 'The provided credentials are incorrect.'
        ], 422);
    }

    $user = Auth::user();
    // Send email verification
    // $user->sendEmailVerificationNotification();

    // Revoke all previous tokens
    $user->tokens()->delete();

    // Create a new token
    $token = $user->createToken('main', ['*'])->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ]);
}


public function logout(Request $request)
{
    // Get the user's token from the request
    $user = $request->user();

    // Revoke the token that was used to authenticate the current request
    $user->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logged out successfully'
    ]);
}

public function emailverify()
{
    $user = Auth::user();
    // Send email verification
    $user->sendEmailVerificationNotification();
    return response()->json([
        'message'=>'A Verification Link Sended to your E-Mail'
    ]);
}

}
