<?php

namespace CodeCoz\AimAdmin\Http\Controllers\Auth;

use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;

use GuzzleHttp\Exception\GuzzleException;

use CodeCoz\AimAdmin\Exceptions\RedirectWithErrorException;
use CodeCoz\AimAdmin\Http\Requests\OtpVerifactionRequest;
use CodeCoz\AimAdmin\Http\Requests\RegistrationRequest;
use CodeCoz\AimAdmin\Services\Auth\RegistrationService;

class RegistrationController extends Controller
{
    protected RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function registration()
    {
        return view('aimadmin::auth.register');
    }

    /**
     * @throws RedirectWithErrorException
     */
    public function sendOTP(RegistrationRequest $request): RedirectResponse|Exception
    {
        try {
            $this->registrationService->sentOtp($request);
            return redirect()->route('otp');
        } catch (RedirectWithErrorException $redirectWithErrorException) {
            throw new RedirectWithErrorException('Error While Processing OTP.');
        }

    }

    public function otp(): View
    {
        $fields = config('aim-admin.registration.fields');
        if (!$fields) {
            throw new RedirectWithErrorException('Fields are not Found.');
        }
        return view('aimadmin::auth.otp', compact('fields'));
    }

    /**
     * @throws GuzzleException
     * @throws RedirectWithErrorException
     */
    public function otpValidate(OtpVerifactionRequest $request): RedirectResponse
    {

        try {
            $this->registrationService->validateOtp($request->otp);
            $this->registrationService->proccedRegistration($request->all());
            return redirect()->route('home');
        } catch (\Exception $e) {
            throw new RedirectWithErrorException('Invalid OTP.');
        }
    }
}
