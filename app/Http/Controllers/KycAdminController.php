<?php

namespace Fickrr\Http\Controllers;

use Fickrr\Models\Freelancer; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Fickrr\Mail\KycApprovedMail;
use Fickrr\Mail\KycRejectedMail;

class KycAdminController extends Controller
{
    public function index()
    {
        $freelancers = Freelancer::withPendingKyc()
            ->paginate(10);

        return view('admin.kyc.verifications', compact('freelancers'));
    }

    public function approve(Freelancer $freelancer)
    {
        $freelancer->update([
            'kyc_verified' => true,
            'kyc_verified_at' => now()
        ]);

        $email = new KycApprovedMail($freelancer);

        // Render the email to HTML and log it (or dump it)
        logger($email->render()); // logs to storage/logs/laravel.log

        // OR: dump directly to screen
        // dd($email->render());

        Mail::to($freelancer->email)->send($email);

        return redirect()->back()->with('success', 'KYC approved successfully');
    }

    public function reject(Freelancer $freelancer)
    {
            $email = new KycRejectedMail($freelancer);

            // Render the email to HTML and log it (or dump it)
            logger($email->render()); // logs to storage/logs/laravel.log
    
            // OR: dump directly to screen
            // dd($email->render());
            Mail::to($freelancer->email)->send($email);
            
            return redirect()->back()->with('success', 'KYC rejection notification sent');
    }

    public function show($id, $type)
    {
        $freelancer = Freelancer::findOrFail($id);

        $pathMap = [
            'government_id' => $freelancer->government_id_path,
            'address_proof' => $freelancer->address_proof_path,
            'biometric_photo' => $freelancer->biometric_photo_path,
            'signature' => $freelancer->signature_data,
        ];

        if (!array_key_exists($type, $pathMap) || !$pathMap[$type]) {
            abort(404, 'Document not found.');
        }

        $path = $pathMap[$type];

        if (!Storage::disk('private')->exists($path)) {
            abort(404, 'File does not exist.');
        }

        $mime = Storage::disk('private')->mimeType($path);
        $file = Storage::disk('private')->get($path);

        return response($file, 200)
            ->header('Content-Type', $mime);
    }
}
