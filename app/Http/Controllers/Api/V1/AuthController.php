<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;



class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
            'role' => 'required|string|in:admin,buyer,seller', // Validate role
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role, // Save role
            ]);

        if($user)
        {
            $token = $user->createToken($user->name . 'Auth-Token')->plainTextToken;

            return response()->json([
            'message' => 'Registration Successful',
            'token_type' => 'Bearer',
            'token' => $token
             ], 201);
        }
        else
        {
            return response()->json([
           'message' => 'Something went wrong while registering.',
            ], 500);
        }
      
       
    }
    
    public function login(Request $request): JsonResponse
    {
        $request->validate([
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:8|max:255',
        ]);

        $user = User::where('email', $request->email)
            ->with([
                'seller', 
                'bankDetails', 
                'seller.packages'])
            ->first();
     
        if(!$user || !hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Incorrect Credentials'
            ], 401);
        }

        $token = $user->createToken($user->name.'Auth-Token')->plainTextToken;


        return response()->json([
        'message' => 'Login Successful',
        'token_type' => 'Bearer',
        'token' => $token,
        'user' => $user
        ], 200);
    }

    public function showResetPasswordForm(Request $request)
    {
        return view('reset-password')->with([
            'errors' => session()->get('errors', new \Illuminate\Support\MessageBag()),
        ]);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset link sent.'], 200)
            : response()->json(['message' => 'Unable to send reset link.'], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // dd($request->token);
            Log::info($request->token);
            // return redirect()->route('password.reset')->with('status', 'Your password has been reset successfully!');
            return view('verification.success', ['message' => 'Your password has been reset successfully!']);
        }
    
        return back()->withInput()->withErrors(['email' => 'Invalid token or email.']);

        // return $status === Password::PASSWORD_RESET
        //     ? response()->json(['message' => 'Password reset successful.'], 200)
        //     : response()->json(['message' => 'Invalid token or email.'], 400);
        // session()->flash('status', 'Your password has been reset successfully!');
        // return $status === Password::PASSWORD_RESET
        //     ? back()
        //     : back()->withErrors(['email' => 'Invalid token or email.']);
    }
}
