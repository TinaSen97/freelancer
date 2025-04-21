<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Fickrr\Models\Freelancer; // You may need to create this model or alias Members
use Fickrr\Models\Settings;
use Fickrr\Models\EmailTemplate;
use Mail;
use Illuminate\Support\Facades\Validator;
use URL;

class FreelancerCommonController extends Controller
{
    public function view_forgot()
    {
        return view('auth.freelancer.forgot');
    }

    // public function update_forgot(Request $request)
    // {
    //     $email = $request->input('email');
    //     $data = ["email" => $email];

    //     $value = Freelancer::verifycheckData($data);
    //     $user = Freelancer::getemailData($email);

    //     if ($value) {
    //         $user_token = $user->user_token;
    //         $name = $user->name;
    //         $setting = Settings::editGeneral(1);

    //         $from_name = $setting->sender_name;
    //         $from_email = $setting->sender_email;
    //         $forgot_url = URL::to('/freelancer/reset/') . '/' . $user_token;
    //         $record = ['user_token' => $user_token, 'forgot_url' => $forgot_url];

    //         $template_subject = EmailTemplate::checkTemplate(4)
    //             ? EmailTemplate::viewTemplate(4)->et_subject
    //             : "Forgot Password";

    //         Mail::send('auth.freelancer.forgot_mail', $record, function ($message) use (
    //             $from_name, $from_email, $email, $name, $template_subject
    //         ) {
    //             $message->to($email, $name)
    //                     ->subject($template_subject)
    //                     ->from($from_email, $from_name);
    //         });

    //         return redirect('/freelancer/forgot')->with('success', 'Password reset link sent!');
    //     } else {
    //         return redirect()->back()->with('error', 'Email not found.');
    //     }
    // }
    public function update_forgot(Request $request)
{
    $email = $request->input('email');
    $data = ["email" => $email];

    $value = Freelancer::verifycheckData($data);
    $user = Freelancer::getemailData($email);

    if ($value) {
        $user_token = $user->user_token;
        $name = $user->name;
        $setting = Settings::editGeneral(1);

        $from_name = $setting->sender_name;
        $from_email = $setting->sender_email;
        $forgot_url = URL::to('/freelancer/reset/') . '/' . $user_token;
        $record = ['user_token' => $user_token, 'forgot_url' => $forgot_url];

        $template_subject = EmailTemplate::checkTemplate(4)
            ? EmailTemplate::viewTemplate(4)->et_subject
            : "Forgot Password";

        //  Render email body view (without sending the email)
        // $emailBody = view('auth.freelancer.forgot_mail', $record)->render();

        // // Print the subject and body (to debug output)
        // echo "<h2>Subject: {$template_subject}</h2>";
        // echo "<hr>";
        // echo $emailBody;

        Mail::send('auth.freelancer.forgot_mail', $record, function ($message) use ($from_name, $from_email, $email, $name, $template_subject) {
            $message->to($email, $name)
                    ->subject($template_subject)
                    ->from($from_email, $from_name);
        });

        // Stop further execution (not sending email)
        return;
    } else {
        return redirect()->back()->with('error', 'Email not found.');
    }
}

    public function view_reset($token)
    {
        return view('auth.freelancer.reset', ['token' => $token]);
    }

    public function update_reset(Request $request)
    {
        $user_token = $request->input('user_token');
        $password = bcrypt($request->input('password'));

        $value = Freelancer::verifytokenData(['user_token' => $user_token]);

        if ($value) {
            $request->validate([
                'password' => 'required|confirmed|min:6',
            ]);

            Freelancer::updatepasswordData($user_token, ['password' => $password]);
            return redirect('/freelancer/login')->with('success', 'Password updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Invalid token.');
        }
    }
}
