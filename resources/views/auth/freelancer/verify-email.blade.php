@component('mail::message')
# Email Verification Required

Please click the button below to verify your email address:

@component('mail::button', ['url' => route('freelancer.verification.verify', ['id' => $user->id, 'hash' => $hash])])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent