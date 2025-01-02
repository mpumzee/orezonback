<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserEmailVerificationController extends Controller
{
    public function verify($id)
    {
        $user = User::find($id);

        if (!$user) {
            return notFoundResponseHandler('User not found or already verified.');
            // return redirect('/')->withErrors(['message' => 'User not found or already verified.']);
        }

        $user->email_verified_at = now();
        $user->save();

        return successResponseHandler('Your email has been verified successfully!', $user);
        // return redirect('/')->with('success', 'Your email has been verified successfully!');
    }
}
