<!DOCTYPE html>
<html>
<head>
    <title>KYC Verification Update</title>
</head>
<body>
    <div style="max-width: 600px; margin: 20px auto; padding: 30px; background: #f8f9fa; border-radius: 10px;">
        <h2 style="color: #dc3545; margin-bottom: 25px;">KYC Verification Requires Attention ⚠️</h2>
        
        <p style="font-size: 16px; line-height: 1.6; color: #343a40;">
            Hello {{ $freelancer->name }},
        </p>
        
        <p style="font-size: 16px; line-height: 1.6; color: #343a40;">
            We regret to inform you that your KYC verification could not be completed. 
            Please review the following issues and resubmit your documents:
        </p>

        <div style="margin: 30px 0; padding: 20px; background: #fff; border-radius: 8px;">
            <ul style="margin: 0; padding-left: 20px; color: #dc3545;">
                <li>Document quality insufficient for verification</li>
                <li>Information mismatch detected</li>
                <li>Expired document submitted</li>
            </ul>
        </div>

        <p style="font-size: 16px; line-height: 1.6; color: #343a40;">
            Please contact support at {{ config('mail.support_email') }} for specific details 
            and to resolve any issues.
        </p>
    </div>
</body>
</html>