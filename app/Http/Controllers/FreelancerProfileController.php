<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Storage;
use Fickrr\Models\Freelancer; 
use Fickrr\Models\Settings;
use Fickrr\Models\Subscription; 
use Fickrr\Models\EmailTemplate;
use Fickrr\Models\Deposit;
use Fickrr\Models\Currencies;
use Mail;
use Paystack;
use IyzipayBootstrap;
use GuzzleHttp\Client;
use CoinGate\CoinGate;
use Cache;
use DGvai\SSLCommerz\SSLCommerz;
use URL;
use Mollie\Laravel\Facades\Mollie;
use MercadoPago;
use Midtrans;
use Illuminate\Support\Facades\Cookie;
use Cashfree;
use Helper;

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


    public function upgrade_subscription($id)
	{
	   $subscr_id = base64_decode($id);
	   $subscr['view'] = Subscription::getSubscription($subscr_id);
	   $sid = 1;
	   $setting['setting'] = Settings::editGeneral($sid);
	   $get_payment = explode(',', $setting['setting']->payment_option);
	  
	  $stripe_mode = $setting['setting']->stripe_mode;
	  $stripe_type = $setting['setting']->stripe_type;
	  return view('auth.freelancer.freelancer-confirm-subscription', ['subscr' => $subscr, 'get_payment' => $get_payment, 'stripe_type' => $stripe_type]);
	}
	
    public function update_subscription(Request $request)
	{
       
	   $encrypter = app('Illuminate\Contracts\Encryption\Encrypter');
      
	   $multicurrency = $encrypter->decrypt($request->input('multicurrency'));
	   $currency = Currencies::getCurrency($multicurrency);
      
	   $currency_symbol = $currency->currency_symbol;
	   $currency_rate = $currency->currency_rate;
	   
	  
	   $user_subscr_id = $encrypter->decrypt($request->input('user_subscr_id'));
	   $subscription_details = Subscription::editsubData($user_subscr_id);
	   $token = $request->input('token');
	   $price = $subscription_details->subscr_price * $currency_rate;
	   $price = round($price,2);
	   /* currency conversation */
	   $default_price = $subscription_details->subscr_price;
	   $default_price = round($default_price,2);
	   /* currency conversation */
	   $user_id =   Auth::guard('freelancer')->user()->id;
	   $user_name =     Auth::guard('freelancer')->user()->name;
	   $order_email =   Auth::guard('freelancer')->user()->email;
	   $purchase_token = rand(111111,999999);
	   $payment_method = $request->input('payment_method');
	   $user_subscr_type = $encrypter->decrypt($request->input('user_subscr_type'));
	   $user_subscr_date = $encrypter->decrypt($request->input('user_subscr_date'));
	   $user_subscr_item_level = $encrypter->decrypt($request->input('user_subscr_item_level'));
	   $user_subscr_item = $encrypter->decrypt($request->input('user_subscr_item'));
	   $user_subscr_download_item = $encrypter->decrypt($request->input('user_subscr_download_item'));
	   $user_subscr_space_level = $encrypter->decrypt($request->input('user_subscr_space_level'));
	   $user_subscr_space = $encrypter->decrypt($request->input('user_subscr_space'));
	   $user_subscr_space_type = $encrypter->decrypt($request->input('user_subscr_space_type'));
	   $website_url = $request->input('website_url');
	   $subscr_value = "+".$user_subscr_date;
	   $subscr_date = date('Y-m-d', strtotime($subscr_value));
	   $sid = 1;
	   $setting['setting'] = Settings::editGeneral($sid);
	   $additional['setting'] = Settings::editAdditional();
	   $bank_details = $setting['setting']->local_bank_details;
	   $admin_amount = $price;
	   $payment_status = 'pending';
	   if($payment_method == 'localbank')
	   {
	   $updatedata = array('user_subscr_price' => $price, 'user_subscr_id' => $user_subscr_id, 'user_purchase_token' => $purchase_token, 'user_subscr_payment_type' => $payment_method, 'user_subscr_payment_status' => $payment_status, 'currency_type' => $currency_symbol, 'currency_type_code' => $multicurrency, 'user_single_price' => $subscription_details->subscr_price);
	   }
	   else
	   {
	   $updatedata = array('user_subscr_price' => $price, 'user_subscr_id' => $user_subscr_id, 'user_subscr_payment_type' => $payment_method, 'user_subscr_payment_status' => $payment_status, 'currency_type' => $currency_symbol, 'currency_type_code' => $multicurrency, 'user_single_price' => $subscription_details->subscr_price);
	   }
	   
	   /* settings */
	   
	   $paypal_email = $setting['setting']->paypal_email;
	   $paypal_mode = $setting['setting']->paypal_mode;
	   $site_currency = $multicurrency;

	   if($paypal_mode == 1)
	   {
	     $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
	   }
	   else
	   {
	     $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	   }
	   $success_url = $website_url.'/subscription-success/'.$purchase_token;
	   $cancel_url = $website_url.'/cancel';
	   
	   $stripe_mode = $setting['setting']->stripe_mode;
	   if($stripe_mode == 0)
	   {
	     $stripe_publish_key = $setting['setting']->test_publish_key;
		 $stripe_secret_key = $setting['setting']->test_secret_key;
	   }
	   else
	   {
	     $stripe_publish_key = $setting['setting']->live_publish_key;
		 $stripe_secret_key = $setting['setting']->live_secret_key;
	   }
	   
	   $two_checkout_mode = $setting['setting']->two_checkout_mode;
	   $two_checkout_account = $setting['setting']->two_checkout_account;
	   $two_checkout_publishable = $setting['setting']->two_checkout_publishable;
	   $two_checkout_private = $setting['setting']->two_checkout_private;
	   
	   $payhere_success_url = $website_url.'/subscription-payhere/'.$purchase_token;
	   
	   /* iyzico */
	   $iyzico_api_key = $additional['setting']->iyzico_api_key;
	   $iyzico_secret_key = $additional['setting']->iyzico_secret_key;
	   $iyzico_mode = $additional['setting']->iyzico_mode;
	   if($iyzico_mode == 0)
	   {
		  $iyzico_url = 'https://sandbox-api.iyzipay.com';
	   }
	   else
	   {
		  $iyzico_url = 'https://api.iyzipay.com';
	   }
	   $iyzico_success_url = $website_url.'/subscription-iyzico/admin-'.$purchase_token;
	   /* iyzico */
	   
	   /* flutterwave */
	   $flutterwave_public_key = $additional['setting']->flutterwave_public_key;
	   $flutterwave_secret_key = $additional['setting']->flutterwave_secret_key;
	   $flutterwave_callback = $website_url.'/subscription-flutterwave';
	   /* flutterwave */
	   
	   /* coingate */
	   $coingate_mode = $additional['setting']->coingate_mode;
	   if($coingate_mode == 0)
	   {
	      $coingate_mode_status = "sandbox";
	   }
	   else
	   {
	      $coingate_mode_status = "live";
	   }
	   $coingate_auth_token = $additional['setting']->coingate_auth_token;
	   $coingate_callback = $website_url.'/subscription-coingate';
	   /* coingate */
	   
	   
	   /* ipay */
	   $ipay_mode = $additional['setting']->ipay_mode;
	   $ipay_vendor_id = $additional['setting']->ipay_vendor_id;
	   $ipay_hash_key = $additional['setting']->ipay_hash_key;
	   $ipay_callback = $website_url.'/subscription-ipay';
	   $ipay_url = 'https://payments.ipayafrica.com/v3/ke';
	   /* ipay */
	   
	   /* payfast */
	   $payfast_mode = $additional['setting']->payfast_mode;
	   $payfast_merchant_id = $additional['setting']->payfast_merchant_id;
	   $payfast_merchant_key = $additional['setting']->payfast_merchant_key;
	   if($payfast_mode == 1)
	   {
	     $payfast_url = "https://www.payfast.co.za/eng/process";
	   }
	   else
	   {
	     $payfast_url = "https://sandbox.payfast.co.za/eng/process";
	   }
	   $payfast_success_url = $website_url.'/subscription-payfast/'.$purchase_token;
	   /* payfast */
	   
	   /* coinpayments */
	   $coinpayments_merchant_id = $additional['setting']->coinpayments_merchant_id;
	   $coinpayments_success_url = $website_url.'/subscription-coinpayments/'.$purchase_token;
	   /* coinpayments */
	   
	   /* instamojo */
	   $instamojo_success_url = $website_url.'/subscription-instamojo/'.$purchase_token;
	   if($additional['setting']->instamojo_mode == 1)
	   {
	     $instamojo_payment_link = 'https://instamojo.com/api/1.1/payment-requests/';
	   }
	   else
	   { 
	      $instamojo_payment_link = 'https://test.instamojo.com/api/1.1/payment-requests/';
	   }
	   $instamojo_api_key = $additional['setting']->instamojo_api_key;
	   $instamojo_auth_token = $additional['setting']->instamojo_auth_token;
	   /* instamojo */
	   
	   /* aamarpay */
		$aamarpay_mode = $additional['setting']->aamarpay_mode;
		$aamarpay_store_id = $additional['setting']->aamarpay_store_id;
		$aamarpay_signature_key = $additional['setting']->aamarpay_signature_key;
		if($aamarpay_mode == 1)
		{
			$aamarpay_url = "http://secure.aamarpay.com/index.php";
		}
		else
		{
			$aamarpay_url = "https://sandbox.aamarpay.com/index.php";
		}
		$aamarpay_success_url = $website_url.'/subscription-aamarpay/'.$purchase_token;
		$aamarpay_cancel_url = $website_url.'/subscription-aamarpay/'.$purchase_token;
		$aamarpay_failed_url = $website_url.'/subscription-aamarpay/'.$purchase_token;
		/* aamarpay */
		
		/* mollie */
		if($additional['setting']->mollie_api_key != "")
		{
		Mollie::api()->setApiKey($additional['setting']->mollie_api_key);
		}
		$mollie_success_url = $website_url.'/subscription-mollie';
		/* mollie */
		
		/* robokassa */
		$shop_identifier = $additional['setting']->shop_identifier;
		$robokassa_password_1 = $additional['setting']->robokassa_password_1;
		/* robokassa */
		
		/* mercadopago */
		$mercadopago_client_id = $additional['setting']->mercadopago_client_id;
	   	$mercadopago_client_secret = $additional['setting']->mercadopago_client_secret;
	   	$mercadopago_mode = $additional['setting']->mercadopago_mode;
	   	$mercadopago_success = $website_url.'/subscription-mercadopago/'.$purchase_token;
	   	$mercadopago_failure = $website_url.'/failure';
	   	$mercadopago_pending = $website_url.'/pending';
	    /* mercadopago */
		
		/* midtrans */
		$midtrans_mode = $additional['setting']->midtrans_mode;
		$midtrans_server_key = $additional['setting']->midtrans_server_key;
		$midtrans_success = $website_url.'/subscription-midtrans/'.$purchase_token;
		if($midtrans_mode == 0)
		{
		   $midtrans_mode_status = false;
		   $midtrans_trans_url = "https://app.sandbox.midtrans.com/snap/v2/vtweb/";
		}
		else
		{
		   $midtrans_mode_status = true;
		   $midtrans_trans_url = "https://app.midtrans.com/snap/v2/vtweb/";
		}
		/* midtrans */
		/* coinbase */
		$coinbase_api_key = $additional['setting']->coinbase_api_key;
		$coinbase_success = $website_url.'/subscription-coinbase/'.$encrypter->encrypt($purchase_token);
		$coinbase_webhooks = $website_url.'/webhooks/coinbase-subscription';
		/* coinbase */
		
		/* cashfree */
	   $cashfree_api_key = $additional['setting']->cashfree_api_key;
	   $cashfree_api_secret = $additional['setting']->cashfree_api_secret;
	   $cashfree_mode = $additional['setting']->cashfree_mode;
	   $cashfree_success = $website_url.'/subscription-cashfree/';
	   /* cashfree */
	   
	   
	   /* nowpayments */
	   $nowpayments_api_key = $additional['setting']->nowpayments_api_key;
	   $nowpayments_ipn_secret = $additional['setting']->nowpayments_ipn_secret;
	   $nowpayments_mode = $additional['setting']->nowpayments_mode;
	   $nowpayments_success = $website_url.'/subscription-nowpayments/'.$encrypter->encrypt($purchase_token);
	   /* nowpayments */
	   
		
		/* settings */
	   Subscription::upFreelancersubscribeData($user_id,$updatedata);
	   if($payment_method == 'paypal')
		  {
		     
			 $paypal = '<form method="post" id="paypal_form" action="'.$paypal_url.'">
			  <input type="hidden" value="_xclick" name="cmd">
			  <input type="hidden" value="'.$paypal_email.'" name="business">
			  <input type="hidden" value="'.$user_subscr_type.'" name="item_name">
			  <input type="hidden" value="'.$purchase_token.'" name="item_number">
			  <input type="hidden" value="'.$price.'" name="amount">
			  <input type="hidden" value="'.$site_currency.'" name="currency_code">
			  <input type="hidden" value="'.$success_url.'" name="return">
			  <input type="hidden" value="'.$cancel_url.'" name="cancel_return">
			  		  
			</form>';
			$paypal .= '<script>window.paypal_form.submit();</script>';
			echo $paypal;
					 
			 
		  }
		  else if($payment_method == 'nowpayments')
		  {
			     // Specify the accepted cryptocurrencies
					// Validate the form input
				$validator = Validator::make($request->all(), [
					//'amount' => 'digits_between:1,99999999999999',
					/*'currency' => 'required|in:BTC,ETH,LTC', */
				]);
		
				if ($validator->fails()) {
					return redirect()->back()->withErrors($validator)->withInput();
				}
		
				// Prepare data for the payment request
				if($nowpayments_mode == 0)
				{
				   $nowpayments_payment_url = 'https://api-sandbox.nowpayments.io/v1/payment/';
				   $nowpayments_invoice_url = 'https://api-sandbox.nowpayments.io/v1/invoice';
				   $nowpayment_redirect = 'https://sandbox.nowpayments.io/payment?iid=';
				}
				else
				{
				   $nowpayments_payment_url = 'https://api.nowpayments.io/v1/payment/';
				   $nowpayments_invoice_url = 'https://api.nowpayments.io/v1/invoice';
				   $nowpayment_redirect = 'https://nowpayments.io/payment?iid=';
				}
		        
				// Make a request to NowPayments API using GuzzleHTTP // https://api-sandbox.nowpayments.io/v1 //https://api.nowpayments.io/v1/payment
				$client = new Client();
				$response = $client->post($nowpayments_payment_url, [
					'json' => [
						'price_amount' => $price,
						'price_currency' => $site_currency,
						'pay_currency' => "BTC", 
						//'ipn_callback_url' => "https://nowpayments.io",
  						'order_id'=> $purchase_token,
  					    'order_description' => $user_subscr_type,
						// Add other parameters as needed
					],
					'headers' => [
						'x-api-key' => $nowpayments_api_key,
					],
				]);
		
				$responseBody = json_decode($response->getBody(), true);
				 //dd($responseBody);
				 
				 $response2 = $client->post($nowpayments_invoice_url, [
					'json' => [
						
						'price_amount' => $responseBody['price_amount'],
						'price_currency' => $site_currency, 
						'order_id' => $responseBody['order_id'],
	                    'order_description' => $user_subscr_type,
						'ipn_callback_url' => "https://nowpayments.io",
  						'success_url'=> $nowpayments_success,
                        'cancel_url' => $cancel_url,
						// Add other parameters as needed
					],
					'headers' => [
						'x-api-key' => $nowpayments_api_key,
					],
				]);
		
				$responseBody2 = json_decode($response2->getBody(), true);
				 
				//dd($responseBody2);
				 
				//$paymentLink = $responseBody['payment_url'];
				
				return redirect($nowpayment_redirect.$responseBody2['id'].'&paymentId='.$responseBody['payment_id']);
		       
				//return view('payment-success', ['paymentLink' => $paymentLink]);
						
		  }
		  else if($payment_method == 'cashfree')
		  {
		  
		      if($site_currency != 'INR')
			   {
		          /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('INR');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('INR');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Cashfree need 'INR' currency. Please contact administrator");
				   }
				   /* currency conversion */ 	   
				
			   }
			   else
			   {
			   $price_amount = $price;
			   }
			 $phone = "9999999999";  
			\Cashfree\Cashfree::$XClientId = $cashfree_api_key;
			\Cashfree\Cashfree::$XClientSecret = $cashfree_api_secret;
			if($cashfree_mode == 0)
			{
			\Cashfree\Cashfree::$XEnvironment = Cashfree\Cashfree::$SANDBOX; //$SANDBOX $PRODUCTION
			$keymode = "sandbox";
			}
			else
			{
			\Cashfree\Cashfree::$XEnvironment = Cashfree\Cashfree::$PRODUCTION;
			$keymode = "production";
			}
			$order_id = "order_".$purchase_token;
			$cashfree = new \Cashfree\Cashfree();
			$x_api_version = "2023-08-01";
			$create_order_request = new \Cashfree\Model\CreateOrderRequest();
			$create_order_request->setOrderAmount($price_amount);
			$create_order_request->setOrderCurrency("INR");
			$create_order_request->setOrderId($order_id);
			$customer_details = new \Cashfree\Model\CustomerDetails();
			$order_meta = new \Cashfree\Model\OrderMeta();
			$customer_details->setCustomerId('customer_'.$user_id);
			$customer_details->setCustomerPhone($phone);
			$customer_details->setCustomerName($user_name);
			$customer_details->setCustomerEmail($order_email);
			$order_meta->setReturnUrl($cashfree_success.'?order_id='.$order_id);
			$create_order_request->setCustomerDetails($customer_details);
			$create_order_request->setOrderMeta($order_meta);
			$create_order_request->setOrderNote($user_subscr_type);
			try {
				$result = $cashfree->PGCreateOrder($x_api_version, $create_order_request);
				//dd($result[0]['order_id']);
				
				//dd($result[0]['payment_session_id']);
				
				$cashfree ='<script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>';
		    $cashfree .= '<script>
		    window.onload = function(){
            const cashfree = Cashfree({
                mode: "'.$keymode.'", 
            });
            
                let checkoutOptions = {
                    paymentSessionId: "'.$result[0]['payment_session_id'].'",
                    redirectTarget: "_self",
                };
                cashfree.checkout(checkoutOptions);
            
			}
           </script>'; 
		    echo $cashfree;
				
				
			} catch (Exception $e) {
				echo 'Exception when calling PGCreateOrder: ', $e->getMessage(), PHP_EOL;
			}
		  

		  }
		  else if($payment_method == 'coinbase')
		  {
		      
			    $url = 'https://api.commerce.coinbase.com/charges';
				$array = [
					'name' => $user_subscr_type,
					'description' => $user_subscr_type,
					'local_price' => [
						'amount' => $price,
						'currency' => $site_currency
					],
					'metadata' => [
						'trx' => $purchase_token
					],
					'pricing_type' => "fixed_price",
					'notification_url' => $coinbase_webhooks,
					'redirect_url' => $coinbase_success,
					'cancel_url' => $cancel_url
				];
		
				$yourjson = json_encode($array);
				$ch = curl_init();
				$apiKey = $coinbase_api_key;
				$header = array();
				$header[] = 'Content-Type: application/json';
				$header[] = 'X-CC-Api-Key: ' . "$apiKey";
				$header[] = 'X-CC-Version: 2018-03-22';
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $yourjson);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch);
				curl_close($ch);
		        $result = json_decode($result);
                if ($result->data->id != '') 
				{
				   return redirect($result->data->hosted_url);
				}
				else
				{
				   return redirect($cancel_url);
				}
		  
		  }
		  else if($payment_method == 'midtrans')
		  {
		        
				if($site_currency != 'IDR')
				 {
				   
				   
				   /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('IDR');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('IDR');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Midtrans need 'IDR' currency. Please contact administrator");
				   }
				   /* currency conversion */
				   
				 }
				 else
				 {
				   $price_amount = $price;
				 }
				 
				 $finpr = round($price_amount,2);
				    $partamt = $finpr * 100;
				    $myamount = str_replace([',', '.'], ['', ''], $partamt);
					
			    Midtrans\Config::$serverKey = $midtrans_server_key;
				// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
				Midtrans\Config::$isProduction = $midtrans_mode_status;
				// Set sanitization on (default)
				Midtrans\Config::$isSanitized = true;
				// Set 3DS transaction for credit card to true
				Midtrans\Config::$is3ds = true;
				
				$params = array(
					'transaction_details' => array(
						'order_id' => $purchase_token,
						'gross_amount' => $myamount,
					),
					'customer_details' => array(
						'first_name' => $user_name,
						'last_name' => $user_name,
						'email' => $order_email,
						
					),
					'callbacks' => array
					(
					  'finish' => $midtrans_success
					),
					
				);
				
				$snapToken = Midtrans\Snap::getSnapToken($params);
		        return redirect($midtrans_trans_url.$snapToken);
		
			  
		  }
		  else if($payment_method == 'mercadopago')
		  {
		     if($site_currency != 'BRL')
			 {
			   /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('BRL');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('BRL');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Mercadopago need 'BRL' currency. Please contact administrator");
				   }
				   /* currency conversion */
				   	   
			 }
			 else
			 {
			   $price_amount = $price;
			 }
			 include(app_path() . '/mercadopago/autoload.php');
			 MercadoPago\SDK::setAccessToken($mercadopago_client_secret);
			 $preference = new MercadoPago\Preference();
             $item = new MercadoPago\Item();
             $item->title = $user_subscr_type;
             $item->quantity = 1;
             $item->unit_price = $price_amount;
		     $item->id = $purchase_token;
             $item->currency_id = "BRL";
             $preference->items = array($item);
             $preference->back_urls = array(
				"success" => $mercadopago_success,
				"failure" => $mercadopago_failure,
				"pending" => $mercadopago_pending
			);
            $preference->payment_methods = array(
				"excluded_payment_types" => array(
				array("id" => "ticket")   
				) );
            $preference->auto_return = "approved";
            $preference->save();
			if($mercadopago_mode == 1)
			{
			return redirect($preference->init_point);
			}
			else
			{
			return redirect($preference->sandbox_init_point);
			}
			 
			 
		  }
		  else if($payment_method == 'robokassa')
		  {
		     if($site_currency != 'RUB')
			 {
			   
			    /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('RUB');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('RUB');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Robokassa need 'RUB' currency. Please contact administrator");
				   }
				   /* currency conversion */   
				   
			 }
			 else
			 {
			   $price_amount = $price;
			 }
			 $mrh_login = $shop_identifier;
			 $mrh_pass1 = $robokassa_password_1;
			 $inv_id = 0;
             $inv_desc = $user_subscr_type;
             $out_summ = $price_amount;
             $shp_item = "1";
             $in_curr = "";
			 $culture = "en";
			 session()->put('purchase_token',$purchase_token);
			 session()->put('robokassa_type','subscription');
             $crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
		     $robokassa = '<form method="post" id="robokassa_form" action="https://auth.robokassa.ru/Merchant/Index.aspx">
			  <input type="hidden" value="'.$mrh_login.'" name="MerchantLogin">
			  <input type="hidden" value="'.$out_summ.'" name="OutSum">
			  <input type="hidden" value="'.$inv_id.'" name="InvId">
			  <input type="hidden" value="'.$inv_desc.'" name="Description">
			  <input type="hidden" value="'.$crc.'" name="SignatureValue">
			  <input type="hidden" value="'.$shp_item.'" name="Shp_item">
			  <input type="hidden" value="'.$in_curr.'" name="IncCurrLabel">
			  <input type="hidden" value="'.$culture.'" name="Culture">		  
			</form>';
			$robokassa .= '<script>window.robokassa_form.submit();</script>';
			echo $robokassa;
			 
			 
		  }
		  else if($payment_method == 'mollie')
	      {
		     
			   
			 $price_amount = ''.sprintf('%0.2f', round($price,2)).'';
			 $payment = Mollie::api()->payments()->create([
			'amount' => [
				'currency' => $site_currency, // Type of currency you want to send
				'value' => $price_amount, // You must send the correct number of decimals, thus we enforce the use of strings
			],
			'description' => $user_subscr_type, 
			'redirectUrl' => $mollie_success_url, // after the payment completion where you to redirect
			]);
			
			$payment = Mollie::api()->payments()->get($payment->id);
			
			session()->put('payment_id',$payment->id);
			session()->put('purchase_token',$purchase_token);
		
			// redirect customer to Mollie checkout page
			return redirect($payment->getCheckoutUrl(), 303);
			 
		  }
		  else if($payment_method == 'aamarpay')
		  {
		     $aamarpay = '<form method="post" id="aamarpay_form" action="'.$aamarpay_url.'">
			  <input type="hidden" name="store_id" value="'.$aamarpay_store_id.'">
              <input type="hidden" name="signature_key" value="'.$aamarpay_signature_key.'">
			  <input type="hidden" name="tran_id" value="'.$purchase_token.'">
			  <input type="hidden" name="amount" value="'.$price.'">
			  <input type="hidden" name="currency" value="'.$site_currency.'">
			  <input type="hidden" name="cus_name" value="'.$user_name.'">
			  <input type="hidden" name="cus_email" value="'.$order_email.'">
			  <input type="hidden" name="cus_add1" value="'.$order_email.'">
			  <input type="hidden" name="cus_phone" value="'.$order_email.'">
			  <input type="hidden" name="desc" value="'.$user_subscr_type.'">
			  <input type="hidden" name="success_url" value="'.$aamarpay_success_url.'">
              <input type="hidden" name="fail_url" value= "'.$aamarpay_failed_url.'">
              <input type="hidden" name="cancel_url" value= "'.$aamarpay_cancel_url.'">
			 
			  		  
			</form>';
			$aamarpay .= '<script>window.aamarpay_form.submit();</script>';
			echo $aamarpay; 
		    
		  }
		  else if($payment_method == 'instamojo')
		  {
		       if($site_currency != 'INR')
			   {
			   
			   
			   /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('INR');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('INR');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Instamojo need 'INR' currency. Please contact administrator");
				   }
				   /* currency conversion */   
					   
			   }
			   else
			   {
			   $price_amount = $price;
			   }
			    $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $instamojo_payment_link);
				curl_setopt($ch, CURLOPT_HEADER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_HTTPHEADER,
							array("X-Api-Key:".$instamojo_api_key,
								  "X-Auth-Token:".$instamojo_auth_token));
				$payload = Array(
					'purpose' => $user_subscr_type,
					'amount' => $price_amount,
					//'phone' => '9876543210',
					'buyer_name' => $user_name,
					'redirect_url' => $instamojo_success_url,
					'send_email' => true,
					//'webhook' => $instamojo_success_url,
					//'send_sms' => false,
					'email' => $order_email,
					'allow_repeated_payments' => false
				);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
				$response = curl_exec($ch);
				curl_close($ch);
				$response = json_decode($response); 
				
				return redirect($response->payment_request->longurl);
				
				
		  
		  }
		  else if($payment_method == 'sslcommerz')
		  {
		       if($site_currency != 'BDT')
			   {
			   /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('BDT');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('BDT');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Sslcommerz need 'BDT' currency. Please contact administrator");
				   }
				   /* currency conversion */   
					   
			   }
			   else
			   {
			   $price_amount = $price;
			   }
		      $sslc = new SSLCommerz();
				$sslc->amount($price_amount)
					->trxid($purchase_token)
					->product($user_subscr_type)
					->customer($user_name,$order_email)
					->setUrl([route('sslcommerz.success'), route('sslcommerz.failure'), route('sslcommerz.cancel'), route('sslcommerz.ipn')])
					->setCurrency('BDT');
				return $sslc->make_payment();
				//BDT

        /**
         * 
         *  USE:  $sslc->make_payment(true) FOR CHECKOUT INTEGRATION
         * 
         * */
		  }
		  /* coinpayments */
		  else if($payment_method == 'coinpayments')
		  {
		     $coinpayments = '<form action="https://www.coinpayments.net/index.php" method="post" id="coinpayments_form">
								<input type="hidden" name="cmd" value="_pay">
								<input type="hidden" name="reset" value="1">
								<input type="hidden" name="merchant" value="'.$coinpayments_merchant_id.'">
								<input type="hidden" name="item_name" value="'.$user_subscr_type.'">	
								<input type="hidden" name="item_desc" value="'.$user_subscr_type.'">
								<input type="hidden" name="item_number" value="'.$purchase_token.'">
								<input type="hidden" name="currency" value="'.$site_currency.'">
								<input type="hidden" name="amountf" value="'.$price.'">
								<input type="hidden" name="want_shipping" value="0">
								<input type="hidden" name="success_url" value="'.$coinpayments_success_url.'">	
								<input type="hidden" name="cancel_url" value="'.$cancel_url.'">	
							</form>';
			$coinpayments .= '<script>window.coinpayments_form.submit();</script>';
			echo $coinpayments;				
		  }
		  /* coinpayments */
		  /* payfast */
		  else if($payment_method == 'payfast')
		  {
		       if($site_currency != 'ZAR')
			   {
			   /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('ZAR');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('ZAR');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Payfast need 'ZAR' currency. Please contact administrator");
				   }
				   /* currency conversion */   
					   
				   
			   }
			   else
			   {
			   $price_amount = $price;
			   }
			 $payfast = '<form method="post" id="payfast_form" action="'.$payfast_url.'">
			  <input type="hidden" name="merchant_id" value="'.$payfast_merchant_id.'">
   			  <input type="hidden" name="merchant_key" value="'.$payfast_merchant_key.'">
   			  <input type="hidden" name="amount" value="'.$price_amount.'">
   			  <input type="hidden" name="item_name" value="'.$user_subscr_type.'">
			  <input type="hidden" name="item_description" value="'.$user_subscr_type.'">
			  <input type="hidden" name="name_first" value="'.$user_name.'">
			  <input type="hidden" name="name_last" value="'.$user_name.'">
			  <input type="hidden" name="email_address" value="'.$order_email.'">
			  <input type="hidden" name="m_payment_id" value="'.$purchase_token.'">
              <input type="hidden" name="email_confirmation" value="1">
              <input type="hidden" name="confirmation_address" value="'.$order_email.'"> 
              <input type="hidden" name="return_url" value="'.$payfast_success_url.'">
			  <input type="hidden" name="cancel_url" value="'.$cancel_url.'">
			  <input type="hidden" name="notify_url" value="'.$cancel_url.'">
			</form>';
			$payfast .= '<script>window.payfast_form.submit();</script>';
			echo $payfast;
					 
			 
		  }
		  
		  /* payfast */
		  else if($payment_method == 'ipay')
		  {
		  
		  	 if($site_currency != 'KES')
			   {
			   /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('KES');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('KES');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "iPay need 'KES' currency. Please contact administrator");
				   }
				   /* currency conversion */ 	   
				   
			   }
			   else
			   {
			   $price_amount = $price;
			   }
		     $fields = array("live"=> $ipay_mode, // 0
                    "oid"=> $purchase_token,
                    "inv"=> $purchase_token,
                    "ttl"=> $price_amount,
                    "tel"=> "000000000000",
                    "eml"=>     Auth::guard('freelancer')->user()->email,
                    "vid"=> $ipay_vendor_id, // demo
                    "curr"=> "KES",
                    "cbk"=> $ipay_callback,
                    "cst"=> "1",
                    "crl"=> "2"
                    );
            
			$datastring =  $fields['live'].$fields['oid'].$fields['inv'].$fields['ttl'].$fields['tel'].$fields['eml'].$fields['vid'].$fields['curr'].$fields['cbk'].$fields['cst'].$fields['crl'];		
			 $hashkey = $ipay_hash_key; // demoCHANGED
			 $generated_hash = hash_hmac('sha1',$datastring , $hashkey);
			 
			 $ipay = '<form method="post" id="ipay_form" action="'.$ipay_url.'">';
			 foreach ($fields as $key => $value) 
			 { 
			  $ipay .= '<input type="hidden" value="'.$value.'" name="'.$key.'">';
			 } 
			$ipay .= '<input name="hsh" type="hidden" value="'.$generated_hash.'">';  		  
			$ipay .= '</form>';
			$ipay .= '<script>window.ipay_form.submit();</script>';
			echo $ipay;
					 
			 
		  }
		  else if($payment_method == 'coingate')
		  {
		  
		     \CoinGate\CoinGate::config(array(
					'environment'               => $coingate_mode_status, // sandbox OR live
					'auth_token'                => $coingate_auth_token,
					'curlopt_ssl_verifypeer'    => TRUE // default is false
					 ));
					 
			  $post_params = array(
			       'id'                => $purchase_token,
                   'order_id'          => $purchase_token,
                   'price_amount'      => $price,
                   'price_currency'    => $site_currency,
                   'receive_currency'  => $site_currency,
                   'callback_url'      => $coingate_callback,
                   'cancel_url'        => $cancel_url,
                   'success_url'       => $coingate_callback,
                   'title'             => $user_subscr_type,
                   'description'       => $user_subscr_type
				   
               );
                
				$order = \CoinGate\Merchant\Order::create($post_params);
				
				if ($order) {
					//echo $order->status;
					
					Cache::put('coingate_id', $order->id, now()->addDays(1));
					Cache::put('purchase_id', $order->order_id, now()->addDays(1));
					//echo $order->id;
					return redirect($order->payment_url);
					
					
				} else {
					return redirect($cancel_url);
				}
					  //return view('test');
	  		 
			 
		  }
		  else if($payment_method == 'flutterwave')
		  {
		  
		       if($site_currency != 'NGN')
			   {
		       
			   /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('NGN');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('NGN');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Flutterwave need ".$setting['setting']->flutterwave_default_currency." currency. Please contact administrator");
				   }
				   /* currency conversion */ 	   
					   
				   
			   }
			   else
			   {
			   $price_amount = $price;
			   }
		       $phone_number = "";
			   $csf_token = csrf_token();
			   $flutterwave = '<form method="post" id="flutterwave_form" action="https://checkout.flutterwave.com/v3/hosted/pay">
	          <input type="hidden" name="public_key" value="'.$flutterwave_public_key.'" />
	          <input type="hidden" name="customer[email]" value="'. Auth::guard('freelancer')->user()->email.'" >
			  <input type="hidden" name="customer[phone_number]" value="'.$phone_number.'" />
			  <input type="hidden" name="customer[name]" value="'.  Auth::guard('freelancer')->user()->name.'" />
			  <input type="hidden" name="tx_ref" value="'.$purchase_token.'" />
			  <input type="hidden" name="amount" value="'.$price_amount.'">
			  <input type="hidden" name="currency" value="'.$setting['setting']->flutterwave_default_currency.'">
			  <input type="hidden" name="meta[token]" value="'.$csf_token.'">
			  <input type="hidden" name="redirect_url" value="'.$flutterwave_callback.'">
			</form>';
			$flutterwave .= '<script>window.flutterwave_form.submit();</script>';
			echo $flutterwave;
			  
		  
		  }
		  else if($payment_method == 'iyzico')
		  {
		     if($site_currency != 'TRY')
			   {
		       /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('TRY');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('TRY');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Iyzico need 'TRY' currency. Please contact administrator");
				   }
				   /* currency conversion */ 	   
					   
			   }
			   else
			   {
			   $price_amount = number_format((float)$price, 2, '.', '');
			   }
			  
		     $endpoint = $website_url."/app/iyzipay-php/iyzico.php";
			 $client = new Client(['base_uri' => $endpoint]);
             $api_key = $iyzico_api_key;
			 $secret_key = $iyzico_secret_key;
			 $iyzi_url = $iyzico_url;
			 $purchased_token = $purchase_token;
			 $amount = $price_amount;
			 $userids =     Auth::guard('freelancer')->user()->id;
			 $usernamer =   Auth::guard('freelancer')->user()->name;
             $response = $client->request('GET', $endpoint, ['query' => [
				'iyzico_api_key' => $api_key, 
				'iyzico_secret_key' => $secret_key,
				'iyzico_url' => $iyzi_url,
				'purchase_token' => $purchased_token,
				'price_amount' => $amount,
				'user_id' => $userids,
				'username' => $usernamer,
				'email' =>  Auth::guard('freelancer')->user()->email,
				'user_token' =>     Auth::guard('freelancer')->user()->user_token,
				'item_name' => $user_subscr_type,
				'iyzico_success_url' => $iyzico_success_url,
				
			]]);
        
            echo $response->getBody();

		  }
		  else if($payment_method == '2checkout')
		  {
		    
			$two_checkout = '<form method="post" id="two_checkout_form" action="https://www.2checkout.com/checkout/purchase">
			  <input type="hidden" name="sid" value="'.$two_checkout_account.'" />
			  <input type="hidden" name="mode" value="2CO" />
			  <input type="hidden" name="li_0_type" value="product" />
			  <input type="hidden" name="li_0_name" value="'.$user_subscr_type.'" />
			  <input type="hidden" name="li_0_price" value="'.$price.'" />
			  <input type="hidden" name="currency_code" value="'.$site_currency.'" />
			  <input type="hidden" name="merchant_order_id" value="'.$purchase_token.'" />';
			  if($two_checkout_mode == 0)
			  {
			  $two_checkout .= '<input type="hidden" name="card_holder_name" value="John Doe" />
			                 <input type="hidden" name="demo" value="Y" />';
			  
			  }
			  $two_checkout .= '<input type="hidden" name="street_address" value="" />
			  <input type="hidden" name="city" value="" />
			  <input type="hidden" name="state" value="" />
			  <input type="hidden" name="zip" value="" />
			  <input type="hidden" name="country" value="" />
			  <input type="hidden" name="x_receipt_link_url" value="subscription" />
			  <input type="hidden" name="email" value="'.$order_email.'" />
			  </form>';
			$two_checkout .= '<script>window.two_checkout_form.submit();</script>';
			echo $two_checkout;
          } 
		  else if($payment_method == 'payumoney')
		  {
		     $additional['settings'] = Settings::editAdditional();
			 $MERCHANT_KEY = $additional['settings']->payu_merchant_key; // add your id
					$SALT = $additional['settings']->payu_salt_key; // add your id
					if($additional['settings']->payumoney_mode == 1)
					{
					$PAYU_BASE_URL = "https://secure.payu.in";
					}
					else
					{
					$PAYU_BASE_URL = "https://test.payu.in";
					}
				if($site_currency != 'INR')
			   {
		          /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('INR');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('INR');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Payumoney need 'INR' currency. Please contact administrator");
				   }
				   /* currency conversion */ 	   
				
			   }
			   else
			   {
			   $price_amount = $price;
			   }
			   $action = '';
				$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				$posted = array();
				$posted = array(
					'key' => $MERCHANT_KEY,
					'txnid' => $txnid,
					'amount' => $price_amount,
					'udf1' => $purchase_token,
					'firstname' => $user_name,
					'email' => $order_email,
					'productinfo' => $user_subscr_type,
					'surl' => $website_url.'/payu_subscription',
					'furl' => $website_url.'/cancel',
					'service_provider' => 'payu_paisa',
				);
				$payu_success = $website_url.'/payu_subscription';
				
				if(empty($posted['txnid'])) {
					$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
				} 
				else 
				{
					$txnid = $posted['txnid'];
				}
				$hash = '';
				$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
				if(empty($posted['hash']) && sizeof($posted) > 0) {
					$hashVarsSeq = explode('|', $hashSequence);
					$hash_string = '';  
					foreach($hashVarsSeq as $hash_var) {
						$hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
						$hash_string .= '|';
					}
					$hash_string .= $SALT;
				
					$hash = strtolower(hash('sha512', $hash_string));
					$action = $PAYU_BASE_URL . '/_payment';
				} 
				elseif(!empty($posted['hash'])) 
				{
					$hash = $posted['hash'];
					$action = $PAYU_BASE_URL . '/_payment';
				}
				$paymoney = '<form action="'.$action.'" method="post" name="payumoney_form">
            <input type="hidden" name="key" value="'.$MERCHANT_KEY.'" />
            <input type="hidden" name="hash" value="'.$hash.'"/>
            <input type="hidden" name="txnid" value="'.$txnid.'" />
			<input type="hidden" name="udf1" value="'.$purchase_token.'" />
            <input type="hidden" name="amount" value="'.$price_amount.'" />
            <input type="hidden" name="firstname" id="firstname" value="'.$user_name.'" />
            <input type="hidden" name="email" id="email" value="'.$order_email.'" />
            <input type="hidden" name="productinfo" value="'.$user_subscr_type.'">
            <input type="hidden" name="surl" value="'.$payu_success.'" />
            <input type="hidden" name="furl" value="'.$cancel_url.'" />
            <input type="hidden" name="service_provider" value="payu_paisa"  />
			</form>';
			/*if(!$hash) {*/
            $paymoney .= '<script>window.payumoney_form.submit();</script>';
			/*}*/
			echo $paymoney;

			   
		  }
		  else if($payment_method == 'payhere')
		  {
		     $additional['settings'] = Settings::editAdditional();
		     $payhere_mode = $additional['settings']->payhere_mode;
			 if($payhere_mode == 1)
			 {
				$payhere_url = 'https://www.payhere.lk/pay/checkout';
			 }
			 else
			 {
				$payhere_url = 'https://sandbox.payhere.lk/pay/checkout';
			 }
			 $payhere_merchant_id = $additional['settings']->payhere_merchant_id;
			 if($site_currency != 'LKR')
			   {
		       /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('LKR');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('LKR');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   }
				   else
				   {
				     return redirect()->back()->with('error', "PayHere need 'LKR' currency. Please contact administrator");
				   }
				   /* currency conversion */ 	   
					   
			   }
			   else
			   {
			   $price_amount = $price;
			   }
		      $payhere = '<form method="post" action="'.$payhere_url.'" id="payhere_form">   
							<input type="hidden" name="merchant_id" value="'.$payhere_merchant_id.'">
							<input type="hidden" name="return_url" value="'.$payhere_success_url.'">
							<input type="hidden" name="cancel_url" value="'.$cancel_url.'">
							<input type="hidden" name="notify_url" value="'.$cancel_url.'">  
							<input type="hidden" name="order_id" value="'.$purchase_token.'">
							<input type="hidden" name="items" value="'.$user_subscr_type.'"><br>
							<input type="hidden" name="currency" value="LKR">
							<input type="hidden" name="amount" value="'.$price_amount.'">  
							
							<input type="hidden" name="first_name" value="'.$user_name.'">
							<input type="hidden" name="last_name" value="'.$user_name.'"><br>
							<input type="hidden" name="email" value="'.$order_email.'">
							<input type="hidden" name="phone" value="'.$order_email.'"><br>
							<input type="hidden" name="address" value="'.$user_subscr_type.'">
							<input type="hidden" name="city" value="'.$user_name.'">
							<input type="hidden" name="country" value="'.$user_name.'">
							  
						</form>'; 
						$payhere .= '<script>window.payhere_form.submit();</script>';
			            echo $payhere;
		  
		  }
		 else if($payment_method == 'razorpay')
		  {
		       $additional['settings'] = Settings::editAdditional();
		       if($site_currency != 'INR')
			   {
		       /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('INR');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('INR');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   $price_amount = $price_amount * 100;
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Razorpay need 'INR' currency. Please contact administrator");
				   }
				   /* currency conversion */ 	   
				   
				   
			   }
			   else
			   {
			   $price_amount = $price * 100;
			   }
			   
			   $csf_token = csrf_token();
			   
			   $logo_url = $website_url.'/public/storage/settings/'.$setting['setting']->site_logo;
			   $script_url = $website_url.'/resources/views/theme/js/vendor.min.js';
			   $callback = $website_url.'/subscription-razorpay';
			   $razorpay = '
			   <script type="text/javascript" src="'.$script_url.'"></script>
			   <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
			   <script>
				var options = {
					"key": "'.$additional['settings']->razorpay_key.'",
					"amount": "'.$price_amount.'", 
					"currency": "INR",
					"name": "'.$user_subscr_type.'",
					"description": "'.$purchase_token.'",
					"image": "'.$logo_url.'",
					"callback_url": "'.$callback.'",
					"prefill": {
						"name": "'.$user_name.'",
						"email": "'.$order_email.'"
						
					},
					"notes": {
						"address": "'.$user_subscr_type.'"
						
						
					},
					"theme": {
						"color": "'.$setting['setting']->site_theme_color.'"
					}
				};
				var rzp1 = new Razorpay(options);
				rzp1.on("payment.failed", function (response){
						alert(response.error.code);
						alert(response.error.description);
						alert(response.error.source);
						alert(response.error.step);
						alert(response.error.reason);
						alert(response.error.metadata);
				});
				
				$(window).on("load", function() {
					 rzp1.open();
					e.preventDefault();
					});
				</script>';
				echo $razorpay;
					
					
		  }
		   
		 else if($payment_method == 'paystack')
		  {
		       if($site_currency != 'NGN')
			   {
		      
			   
			   /* currency conversion */
				   $check_currency = Currencies::CheckCurrencyCount('NGN');
				   if($check_currency != 0)
				   {
				   $currency_data = Currencies::getCurrency('NGN');
	               $default_currency_rate = $currency_data->currency_rate;
				   $default_price_value = $default_price * $default_currency_rate;
				   $price_amount = round($default_price_value,2);
				   $price_amount = $price_amount * 100;
				   }
				   else
				   {
				     return redirect()->back()->with('error', "Paystack need ".$setting['setting']->paystack_default_currency." currency. Please contact administrator");
				   }
				   /* currency conversion */ 	   
					   
				   
			   }
			   else
			   {
			   $price_amount = $price * 100;
			   }
		       
			   
		       $callback = $website_url.'/subscription-paystack';
			   $csf_token = csrf_token();
			   
			   $reference = $request->input('reference');
			   $paystack = '<form method="post" id="stack_form" action="'.route('paystack').'">
					  <input type="hidden" name="_token" value="'.$csf_token.'">
					  <input type="hidden" name="email" value="'.$order_email.'" >
					  <input type="hidden" name="order_id" value="'.$purchase_token.'">
					  <input type="hidden" name="amount" value="'.$price_amount.'">
					  <input type="hidden" name="quantity" value="1">
					  <input type="hidden" name="currency" value="'.$setting['setting']->paystack_default_currency.'">
					  <input type="hidden" name="reference" value="'.$reference.'">
					  <input type="hidden" name="callback_url" value="'.$callback.'">
					  <input type="hidden" name="metadata" value="'.$purchase_token.'">
					  <input type="hidden" name="key" value="'.$setting['setting']->paystack_secret_key.'">
					</form>';
					$paystack .= '<script>window.stack_form.submit();</script>';
					echo $paystack;
			 
		  }
		 
		 /* wallet */
		 if($payment_method == 'wallet')
		 {
		 $earns =   Auth::guard('freelancer')->user()->earnings * $currency_rate;
		 $customer_earns = round($earns,2);
		 
		    if($customer_earns >= $price)
			{
			
			        $user_token =   Auth::guard('freelancer')->user()->user_token;
			        /*$earn_wallet = $customer_earns - $price;*/
					
					$balance_wallet =   Auth::guard('freelancer')->user()->earnings - $default_price;
					$walet_data = array('earnings' => $balance_wallet); 
					Freelancer::updateData($user_token,$walet_data);
					$payment_gateway_status = 'completed';
					
					$checkoutdata = array('user_subscr_type' => $user_subscr_type, 'user_subscr_date' => $subscr_date, 'user_subscr_item_level' => $user_subscr_item_level, 'user_subscr_item' => $user_subscr_item, 'user_subscr_download_item' => $user_subscr_download_item, 'user_subscr_space_level' => $user_subscr_space_level, 'user_subscr_space' => $user_subscr_space, 'user_subscr_space_type' => $user_subscr_space_type,  'user_subscr_payment_status' => $payment_gateway_status);
					Subscription::confirmsubscriFreelancerData($user_id,$checkoutdata);
					/* subscription email */
					$sid = 1;
					$setting['setting'] = Settings::editGeneral($sid);
					$currency = $site_currency;
					$subscr_price = $subscription_details->subscr_price;
					$subscri_date = $subscription_details->subscr_duration;
					$admin_name = $setting['setting']->sender_name;
					$admin_email = $setting['setting']->sender_email;
					$buyer_name =   Auth::guard('freelancer')->user()->name;
					$buyer_email =  Auth::guard('freelancer')->user()->email;
					$buyer_data = array('user_subscr_type' => $user_subscr_type, 'user_subscr_date' => $subscr_date, 'subscr_duration' =>  $subscri_date, 'subscr_price' => $subscr_price, 'currency' => $currency); 
					/* email template code */
					$checktemp = EmailTemplate::checkTemplate(20);
					if($checktemp != 0)
					{
						$template_view['mind'] = EmailTemplate::viewTemplate(20);
						$template_subject = $template_view['mind']->et_subject;
					}
					else
					{
						$template_subject = "Subscription Upgrade";
					}
					/* email template code */
					Mail::send('subscription_mail', $buyer_data , function($message) use ($admin_name, $admin_email, $buyer_name, $buyer_email, $template_subject) {
						$message->to($buyer_email, $buyer_name)
						->subject($template_subject);
						$message->from($admin_email,$admin_name);
					});
					/* subscription email */
                    return view('success');
					
			} 
			else
			{
			    return redirect()->back()->with('error', 'Please check your wallet balance amount');
			}
		 
		 }
		 
		 /* localbank */
		 if($payment_method == 'localbank')
		 {
			$bank_data = array('purchase_token' => $purchase_token, 'bank_details' => $bank_details);
			return view('upgrade-bank-details')->with($bank_data);
		 }
		  
		  
		  /* stripe code */
		  
		 
		  
		  if($payment_method == 'stripe')
		  {
		     if($setting['setting']->stripe_type == "intents") // Intents API
			 {       
			 
			       if($site_currency == 'INR')
					{
						$finpr = round($price,2);
						$partamt = $finpr * 100;
						$myamount = str_replace([',', '.'], ['', ''], $partamt);
					}
					else
					{
					    $finpr = round($price,2);
						$myamount = $finpr * 100;
					}	      
					\Stripe\Stripe::setApiKey($stripe_secret_key);
					$customer = \Stripe\Customer::create(array( 
					'name' => $user_name,
					'description' => $user_subscr_type,        
					'email' => $order_email,
					"address" => ["city" => "", "country" => "", "line1" => $order_email, "line2" => "", "postal_code" => "", "state" => ""],
					'shipping' => [
						  'name' => $user_name,
						  'address' => [
							'country' => 'us',
							'state' => '',
							'city' => '',
							'line1' => $order_email,
							'line2' => '',
							'postal_code' => ''
						  ]
						]
					));
        		    $payment_intent = \Stripe\PaymentIntent::create([
						'description' => $user_subscr_type,
						'amount' => $myamount,
						'currency' => $site_currency,
						'customer' => $customer->id,
						'metadata' => [
						'order_id' => $purchase_token
					    ],
						'shipping' => [
							'name' => $user_name,
							'address' => [
							  'line1' => $order_email,
							  'postal_code' => '',
							  'city' => '',
							  'state' => '',
							  'country' => 'us',
							],
						  ],
						'payment_method_types' => ['card'],
					]);
		            $intent = $payment_intent->client_secret;
				  $final_amount = $price;
			       $data = array('stripe_publish' => $stripe_publish_key, 'stripe_secret' => $stripe_secret_key, 'intent' => $intent, 'myamount' => $myamount, 'final_amount' => $final_amount, 'site_currency' => $site_currency, 'purchase_token' => $purchase_token);
	   
	   
	              return view('stripe-subscription')->with($data); 

             
						
			}
			else  // Charges API
			{
			   
			   $stripe = array(
					"secret_key"      => $stripe_secret_key,
					"publishable_key" => $stripe_publish_key
				);
			 
				\Stripe\Stripe::setApiKey($stripe['secret_key']);
			 
				$customer = \Stripe\Customer::create(array( 
					'name' => $user_name,
					'description' => $user_subscr_type,        
					'email' => $order_email, 
					'source'  => $token,
					'customer' => $order_email, 
					"address" => ["city" => "", "country" => "", "line1" => $order_email, "line2" => "", "postal_code" => "", "state" => ""],
					'shipping' => [
						  'name' => $user_name,
						  'address' => [
							'country' => 'us',
							'state' => '',
							'city' => '',
							'line1' => $order_email,
							'line2' => '',
							'postal_code' => ''
						  ]
						]
	
                ));
			    
				if($site_currency == 'INR')
				{
				$finpr = round($price,2);
				$partamt = $finpr * 100;
				$myamount = str_replace([',', '.'], ['', ''], $partamt);
				}
				else
				{
				$finpr = round($price,2);
				$myamount = $finpr * 100;
				}
			 
				
				$subscribe_name = $user_subscr_type;
				$subscribe_price = $myamount;
				$currency = $site_currency;
				$book_id = $purchase_token;
			 
				
				$charge = \Stripe\Charge::create(array(
					'customer' => $customer->id,
					'amount'   => $subscribe_price,
					'currency' => $currency,
					'description' => $subscribe_name,
					'metadata' => array(
						'order_id' => $book_id
					)
				));
			 
				
				$chargeResponse = $charge->jsonSerialize();
			 
				
				if($chargeResponse['paid'] == 1 && $chargeResponse['captured'] == 1) 
				{
			 
					
										
					$payment_token = $chargeResponse['balance_transaction'];
					$purchased_token = $book_id;
					$payment_gateway_status = 'completed';
					
					$checkoutdata = array('user_subscr_type' => $user_subscr_type, 'user_subscr_date' => $subscr_date, 'user_subscr_item_level' => $user_subscr_item_level, 'user_subscr_item' => $user_subscr_item, 'user_subscr_download_item' => $user_subscr_download_item, 'user_subscr_space_level' => $user_subscr_space_level, 'user_subscr_space' => $user_subscr_space, 'user_subscr_space_type' => $user_subscr_space_type,  'user_subscr_payment_status' => $payment_gateway_status);
					Subscription::confirmsubscriData($user_id,$checkoutdata);
					/* subscription email */
					$sid = 1;
					$setting['setting'] = Settings::editGeneral($sid);
					$currency = $site_currency;
					$subscr_price = $subscription_details->subscr_price;
					$subscri_date = $subscription_details->subscr_duration;
					$admin_name = $setting['setting']->sender_name;
					$admin_email = $setting['setting']->sender_email;
					$buyer_name =   Auth::guard('freelancer')->user()->name;
					$buyer_email =  Auth::guard('freelancer')->user()->email;
					$buyer_data = array('user_subscr_type' => $user_subscr_type, 'user_subscr_date' => $subscr_date, 'subscr_duration' =>  $subscri_date, 'subscr_price' => $subscr_price, 'currency' => $currency); 
					/* email template code */
					$checktemp = EmailTemplate::checkTemplate(20);
					if($checktemp != 0)
					{
						$template_view['mind'] = EmailTemplate::viewTemplate(20);
						$template_subject = $template_view['mind']->et_subject;
					}
					else
					{
						$template_subject = "Subscription Upgrade";
					}
					/* email template code */
					Mail::send('subscription_mail', $buyer_data , function($message) use ($admin_name, $admin_email, $buyer_name, $buyer_email, $template_subject) {
						$message->to($buyer_email, $buyer_name)
						->subject($template_subject);
						$message->from($admin_email,$admin_name);
					});
					/* subscription email */
					$data_record = array('payment_token' => $payment_token);
					return view('success')->with($data_record);
					
					
				}
			   
			}	
				
		  /* stripe code */
		  $subscr_id = $user_subscr_id;
	   	  $subscr['view'] = Subscription::getSubscription($subscr_id);
	      $get_payment = explode(',', $setting['setting']->payment_option);
	      $totaldata = array('subscr' => $subscr, 'get_payment' => $get_payment);
		  return view('freelancer-confirm-subscription')->with($totaldata);
	   }
	
	
	}

}
