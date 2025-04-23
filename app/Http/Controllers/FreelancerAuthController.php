<?php

namespace Fickrr\Http\Controllers;

use Fickrr\Http\Controllers\Controller;
use Fickrr\Models\Freelancer;
use Illuminate\Support\Str; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Fickrr\Models\Settings;

use Illuminate\Auth\Events\Registered;

class FreelancerAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:freelancer')->except(['logout', 'dashboard']);
    }

    public function showRegistrationForm()
    {
        return view('auth.freelancer-register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();  
        // Handle KYC document storage
        
        $freelancer = Freelancer::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),
            'user_token'        => Str::random(40),
        ]);
    
       
        event(new Registered($freelancer));
        
        Auth::guard('freelancer')->login($freelancer);  

        return redirect()->route('freelancer.verification.notice');
    }

    public function showLoginForm()
    {
        return view('auth.freelancer-login');
    }

    public function dashboard()
    {
        return redirect()->route('freelancer.profile-settings.edit');
    }

    protected function guard()
    {
        return Auth::guard('freelancer');
    }

    public function login(Request $request)
    {
        \Auth::logout();
        $additional_settings = Settings::editAdditional();
        $credentials =  $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('freelancer')->attempt($credentials, $request->remember)) {

                if($additional_settings->subscription_mode == 0)
				{ 
				    return redirect('/freelancer/login');
				}
				else
				{
				//   if(auth()->user()->user_type == 'vendor')
				//   {
				// 	  if(auth()->user()->user_subscr_date >= date('Y-m-d'))
				// 	  {
				// 		return redirect('/');
				// 	  }
				// 	  else
				// 	  {
						return redirect('/freelancer-subscription');
					//   }	
				   }
				//    else
				//    {
				// 	 return redirect('/'); //return redirect('/profile-settings');
				//    }
					
            return redirect()->intended(route('freelancer.dashboard'));
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout()
    {
        Auth::guard('freelancer')->logout();
        request()->session()->invalidate();
        return redirect('/freelancer/login');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:freelancers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'government_id' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'address_proof' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'biometric_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048', 'dimensions:ratio=1'],
            'signature' => ['required', 'string', 'regex:/^data:image\/(png|jpg);base64,/'],
            'kyc_terms' => ['required', 'accepted']
        ]);
    }

    protected function create(array $data)
    {
        $freelancer = Freelancer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'government_id_path' => $data['government_id']->store('', 'kyc'),
            'address_proof_path' => $data['address_proof']->store('', 'kyc'),
            'biometric_photo_path' => $data['biometric_photo']->store('', 'kyc'),
        ]);

        return $freelancer;
    }
}