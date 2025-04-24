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
        'user_subscr_id',
    'user_subscr_type',
    'user_subscr_price',
    'user_subscr_date',
    'user_subscr_payment_status',
    'user_subscr_payment_type',
    'user_subscr_item_level',
    'user_subscr_item',
    'user_subscr_download_item',
    'user_today_download_limit',
    'user_today_download_date',
    'user_subscr_space_level',
    'user_subscr_space',
    'user_subscr_space_type',

    // Payment Options
    'user_payment_option',

    // Currency & Pricing
    'currency_type',
    'currency_type_code',
    'user_single_price',

    // Stripe
    'user_stripe_type',
    'user_stripe_mode',
    'user_test_publish_key',
    'user_test_secret_key',
    'user_live_publish_key',
    'user_live_secret_key',

    // PayPal
    'user_paypal_email',
    'user_paypal_mode',

    // Paystack
    'user_paystack_public_key',
    'user_paystack_secret_key',
    'user_paystack_merchant_email',

    // Razorpay
    'user_razorpay_key',
    'user_razorpay_secret',
        
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

    
  public static function updateData($token,$data){
    self::where('user_token', $token)->update($data);
  }
  
}
