<!DOCTYPE html>
<html>
<head>
    <title>KYC Verification Approved</title>
</head>
<body>
    <div style="max-width: 600px; margin: 20px auto; padding: 30px; background: #f8f9fa; border-radius: 10px;">
        <h2 style="color: #2a9055; margin-bottom: 25px;">KYC Verification Approved 🎉</h2>
        
        <p style="font-size: 16px; line-height: 1.6; color: #343a40;">
            Hello {{ $freelancer->name }},
        </p>
        
        <p style="font-size: 16px; line-height: 1.6; color: #343a40;">
            We're pleased to inform you that your KYC verification has been successfully approved. 
            You now have full access to all platform features.
        </p>

        <div style="margin: 30px 0; padding: 20px; background: #fff; border-radius: 8px;">
            <p style="margin: 0; font-size: 14px; color: #6c757d;">
                Verification Date: {{ $freelancer->kyc_verified_at->format('F j, Y H:i') }}<br>
                Verified Account: {{ $freelancer->email }}
            </p>
        </div>

        <p style="font-size: 16px; line-height: 1.6; color: #343a40;">
            Thank you for completing the verification process. Happy freelancing!
        </p>
    </div>
</body>
</html>