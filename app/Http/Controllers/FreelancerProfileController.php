<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage;
use Fickrr\Models\Freelancer; 


class FreelancerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::guard('freelancer')->user();

        if (!$user) {
            // Redirect to login page or show an error
            return redirect()->route('freelancer.login')->with('error', 'Please log in to access this page.');
        }
        
        return view('auth.freelancer.profile-settings.edit', compact('user'));
        
    }

    public function update(Request $request)
    {
        $user = Auth::guard('freelancer')->user();

        // Only update the government_id field if the file is provided
        if ($request->hasFile('government_id')) {
            $governmentIdPath = $request->file('government_id')->store('kyc-docs', 'private');
            $user->government_id_path = $governmentIdPath;  // Set the path if file exists
        }
        
        // Only update the address_proof field if the file is provided
        if ($request->hasFile('address_proof')) {
            $addressProofPath = $request->file('address_proof')->store('kyc-docs', 'private');
            $user->address_proof_path = $addressProofPath;  // Set the path if file exists
        }
        
        // Only update the biometric_photo field if the file is provided
        if ($request->hasFile('biometric_photo')) {
            $biometricPhotoPath = $request->file('biometric_photo')->store('kyc-photos', 'private');
            $user->biometric_photo_path = $biometricPhotoPath;  // Set the path if file exists
        }
        
        // Only store signature if provided
        if ($request->filled('signature_data')) {
            $signatureData = $request->signature_data;
            $signaturePath = 'signatures/' . Str::uuid() . '.png';
            Storage::disk('private')->put($signaturePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $signatureData)));
            $user->signature_data = $signaturePath;  // Set the path if signature exists
        }
        
        // Validate and update other fields
        $validated = $request->validate([
            'skills' => 'required|string|max:1000',
            'experience' => 'required|string|max:1000',
            'bio' => 'required|string|max:2000',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'pinterest_url' => 'nullable|url|max:255',
        ]);

        // Clean and save skills as comma-separated string
        $skillsRaw = $validated['skills'];
        $skillsArray = array_map('trim', explode(',', $skillsRaw));
        $cleanSkills = implode(', ', $skillsArray);

        $user->skills = $cleanSkills;
        $user->experience = $validated['experience'];
        $user->bio = $validated['bio'];

        // Update social URLs if they are provided
        $user->facebook_url = $validated['facebook_url'] ?? null;
        $user->twitter_url = $validated['twitter_url'] ?? null;
        $user->instagram_url = $validated['instagram_url'] ?? null;
        $user->linkedin_url = $validated['linkedin_url'] ?? null;
        $user->pinterest_url = $validated['pinterest_url'] ?? null;

        // Explicitly set KYC status fields (it will be false if no documents are uploaded)
        $user->kyc_verified = false;
        $user->kyc_verified_at = null;
        
        // Save user data
        $user->save();

        // Redirect with success message
        return redirect()->route('freelancer.profile-settings.edit')
            ->with('success', 'Profile updated successfully');
    }


    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg',
                'max:2048',
                function ($attribute, $value, $fail) use ($request) {
                    list($width, $height) = getimagesize($value->path());
                    $type = $request->input('type');

                    if ($type === 'profile' && ($width != 100 || $height != 100)) {
                        $fail('Profile image must be exactly 100x100 pixels');
                    }

                    if ($type === 'cover' && ($width != 750 || $height != 370)) {
                        $fail('Cover image must be exactly 750x370 pixels');
                    }
                }
            ],
            'type' => 'required|in:profile,cover'
        ]);

        try {
            $user = Auth::guard('freelancer')->user();
            $image = $request->file('image');
            $type = $request->input('type');

            // Choose paths
            $dir = public_path("uploads/freelancers/" . ($type === 'profile' ? 'profiles' : 'covers'));
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            $filename = $type . '-' . $user->id . '-' . time() . '.' . $image->getClientOriginalExtension();
            $filePath = $dir . '/' . $filename;

            // Resize & save image
            $img = Image::make($image);
            if ($type === 'profile') {
                $img->fit(100, 100);
            } else {
                $img->fit(750, 370);
            }

            $img->save($filePath, 80); // Save with 80% quality

            // Update user model
            $relativePath = "public/uploads/freelancers/" . ($type === 'profile' ? 'profiles' : 'covers') . '/' . $filename;
            if ($type === 'profile') {
                $user->profile_picture = $relativePath;
            } else {
                $user->cover_photo = $relativePath;
            }
            $user->save();

            return response()->json([
                'status' => 'success',
                'url' => asset($relativePath)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Image upload failed: ' . $e->getMessage()
            ], 500);
        }
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
