<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Support\Facades\Hash;
use App\Models\User;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    
    // Show forgot password form
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'old_password' => 'required',
            'new_password' => 'required|min:8', // use confirmed for re-check
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (! $user) {
            return back()->withErrors(['email' => 'No user found with this email.']);
        }

        if (! Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('login')->with('status', 'Password updated successfully, please login again.');
    }
    
    
    
}
