@component('mail::message')
    # Reset Password

    You are receiving this email because we received a password reset request for your account.

    Your OTP : {{$otp}}

    This OTP will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.

    If you did not request a password reset, no further action is required.

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
