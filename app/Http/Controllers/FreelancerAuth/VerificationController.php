<?php

namespace App\Http\Controllers\FreelancerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo = '/freelancer/dashboard';

    public function __construct()
    {
        $this->middleware('auth:freelancer');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        return $request->user('freelancer')->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.freelancer.verify');
    }
}