<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Services\Auth;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Exception\GuzzleException;

use CodeCoz\AimAdmin\Constants\AG3;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use CodeCoz\AimAdmin\Exceptions\RedirectWithErrorException;
use CodeCoz\AimAdmin\Helpers\Helper;
use CodeCoz\AimAdmin\Http\Requests\RegistrationRequest;

class RegistrationService
{
    protected string $token;

    public function __construct(protected LoginService $loginService)
    {
        $this->token = config('aim-admin.auth_token');
    }


    /**
     * @throws RedirectWithErrorException
     */
    public function sentOtp(RegistrationRequest $request)
    {
        if (!Helper::isValidEmail($request->email)) {
            throw new RedirectWithErrorException("Please Enter Valid Email.");
        }

        $request->session()->put('user_registration_data', $request->all());

        $response = Http::requestWith($this->token)->post(AG3::SEND_OTP, [
            "email" => $request->email,
            "msisdn" => '01900000000',
            "isSendEmail" => false,
            "isSendMobile" => true,
            "message" => "$#OTP#$",
            "otpLength" => 6,
            "otpSource" => "WEB"
        ]);
        if ($response->ok()) {
            return true;
        }
        throw new RedirectWithErrorException('Unable to Process OTP.');
    }

    /**
     * @throws RedirectWithErrorException
     */
    public function validateOtp($otp)
    {
        $savedUserData = Session::get('user_registration_data');
        $email = $savedUserData['email'];
        $response = Http::requestWith($this->token)->post(AG3::VERIFY_OTP, [
            "email" => $email,
            "msisdn" => '01900000000',
            "appID" => "1234",
            "otpCode" => $otp
        ]);
        $response = $response->getBody()->getContents();
        $statusObj = json_decode($response);
        if ($statusObj->data) {
            Session::put('email', $email);
            return true;
        }
        throw new RedirectWithErrorException('OTP Mismatched.');
    }


    /**
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws RedirectWithErrorException
     * @throws \Exception
     */
    public function proccedRegistration($registrationSaveRequest)
    {
        $email = Session::get('email');
        if (!$email) {
            throw new RedirectWithErrorException('Unexpected Error Occurred.');
        }
        $this->loginService->createUserAGW3($email);
        $this->loginService->tokenGenerationSetCookie($email, $registrationSaveRequest['password']);
        return true;
    }

}
