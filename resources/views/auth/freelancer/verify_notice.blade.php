{{-- resources/views/freelancer/verify_notice.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body>
    <h2>Verify Your Email Address</h2>

    @if (session('resent'))
        <p style="color: green;">A new verification link has been sent to your email address.</p>
    @endif

    <p>Before proceeding, please check your email for a verification link.</p>
    <p>If you did not receive the email,</p>

    <form method="POST" action="{{ route('freelancer.verification.resend') }}">
        @csrf
        <button type="submit">Click here to request another</button>
    </form>

    <form method="POST" action="{{ route('freelancer.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
