<?php
namespace Fickrr\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Notifications\Notifiable;

class Freelancer extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use Notifiable;

    protected $guard = 'freelancer';

    protected $fillable = [
        'name',
        'email',
        'user_token',
        'password',
        'skills',
        'experience',
        'bio',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'pinterest_url',
        'profile_picture',
        'cover_photo',
        'government_id_path',
        'address_proof_path',
        'biometric_photo_path',
        'signature_data',
        'kyc_verified',
        'kyc_verified_at',
        
    ];

    protected $hidden = [
        'password', 
        'remember_token',
    ];

    /**
     * Check if a freelancer exists with the given email.
     */
    public static function verifycheckData($data)
    {
        return self::where('email', $data['email'])->exists();
    }

    /**
     * Get freelancer data by email.
     */
    public static function getemailData($email)
    {
        return self::where('email', $email)->first(); // returns Eloquent model
    }

    /**
     * Verify user token.
     */
    public static function verifytokenData($data)
    {
        return self::where('user_token', $data['user_token'])->exists();
    }

    /**
     * Update password using user_token.
     */
    public static function updatepasswordData($user_token, $record)
    {
        return self::where('user_token', $user_token)->update($record);
    }

    public function scopeWithPendingKyc($query)
    {
        return $query->where('kyc_verified', false)
            ->whereNotNull('government_id_path')
            ->whereNotNull('address_proof_path')
            ->whereNotNull('biometric_photo_path');
    }
}
