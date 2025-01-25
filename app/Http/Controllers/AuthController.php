<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function usersShow()
    {
        $users = User::all();
        return $users;
    }
    public function usersIdShow($id)
    {
        $users = User::find($id);
        return $users;
    }


    public function registerUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'lastName' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|email',
            'password' => ['confirmed', Password::min(6)->mixedCase()->numbers()]
        ]);
        $user = User::create([
            'name' => $data['name'],
            'lastName' => $data['lastName'],
            'userName'=>encrypt($data['password']),
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => bcrypt($data['password'])
        ]);


        return response('user Registered', 200);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->validate([
            'name' => 'required|string',
            'lastName' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|email',
            'password' => ['nullable', 'confirmed', Password::min(6)->mixedCase()->numbers()]
        ]);

        $user->update([
            'name' => $data['name'] ?? $user->name,
            'lastName' => $data['lastName'] ?? $user->lastName,
            'userName'=>encrypt($data['password']) ?? $user->userName,
            'role' => $data['role'] ?? $user->role,
            'email' => $data['email'] ?? $user->email,
            'password' => bcrypt($data['password']) ?? $user->password,
        ]);
    }

    public function delete($id)
    {
        $user=User::find($id);
        $user->delete();
        return response('User Deleted',200);
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

    public function usersAuthShow()
    {
        $user = Auth::user();
    if (!$user) {
        return response()->json(['error' => 'Unauthorized: Token missing or invalid'], 401);
    }
    return $user;
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
            'message' => 'A Verification Link Sended to your E-Mail'
        ]);
    }


    public function sendEmailForgotPassword(Request $request)
    {
        $data=$request->validate([
            'email'=>'required|email'
        ]);

        $user=User::where('email',$data['email'])->first();
        if(!$user){
            return response('User not found',200);
        }


        try {
            $decryptedUserName = decrypt($user->userName);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Decryption failed: ' . $e->getMessage()], 500);
        }

        $combinedData = [
            'user' => $user,
            'userName' => $decryptedUserName,
        ];
            Mail::to($user->email)->send(new ForgotPasswordMail($combinedData));
        return response('Email sended',200);
        // return response($combinedData,200);

    }
}
