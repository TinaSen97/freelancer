<?php

namespace Fickrr\Http\Controllers\FreelancerAuth;

use Fickrr\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    use SendsPasswordResetEmails, ResetsPasswords {
        SendsPasswordResetEmails::broker insteadof ResetsPasswords;
    }

    protected $redirectTo = '/freelancer/dashboard';

    protected function credentials(Request $request)
    {
        return $request->only('email');
    }

    public function showLinkRequestForm()
    {
        return view('auth.freelancer.passwords.email');
    }

    public function __construct()
    {
        $this->middleware('guest:freelancer');
    }

    public function broker()
    {
        return Password::broker('freelancers');
    }

    protected function guard()
    {
        return auth()->guard('freelancer');
    }
}