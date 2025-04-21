<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

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

        // Social URLs
        $user->facebook_url = $validated['facebook_url'] ?? null;
        $user->twitter_url = $validated['twitter_url'] ?? null;
        $user->instagram_url = $validated['instagram_url'] ?? null;
        $user->linkedin_url = $validated['linkedin_url'] ?? null;
        $user->pinterest_url = $validated['pinterest_url'] ?? null;

        $user->save();

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
}
