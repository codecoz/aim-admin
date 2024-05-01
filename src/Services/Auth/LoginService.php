<?php

declare(strict_types=1);


namespace CodeCoz\AimAdmin\Services\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use GuzzleHttp\Exception\GuzzleException;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

use CodeCoz\AimAdmin\Constants\AG3;
use CodeCoz\AimAdmin\Contracts\Service\LoginServiceInterface;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use CodeCoz\AimAdmin\Admin;
use CodeCoz\AimAdmin\Helpers\Helper;
use CodeCoz\AimAdmin\Traits\APITrait;
use CodeCoz\AimAdmin\Traits\HelperTrait;

use Exception;
use CodeCoz\AimAdmin\Exceptions\RedirectWithErrorException;

class LoginService implements LoginServiceInterface
{
    use HelperTrait, APITrait;

    /**
     * @throws GuzzleException
     * @throws NotFoundException
     */
    public function userLogin(Request $request)
    {
        // Generate and set the token
        $this->tokenGenerationSetCookie($request->email, $request->password);
    }

    /**
     * @throws GuzzleException
     * @throws NotFoundException
     * @throws Exception
     */
    public function tokenGenerationSetCookie(string $email, string $password): void
    {
        $payload = $this->requestAccessToken($email, $password);

        $userId = $this->getTokenInfo($payload, 'userID');

        $userEmail = $this->getTokenInfo($payload, 'userEmail');

        $inHouse = $this->isAd($email);

        if ($inHouse && empty($userId)) {
            $userId = $this->createUserAGW3($userEmail);
        }

        $userObject = $this->getUserPayload($payload, $userId, $email);

        $this->setCookiesSessionToken($userObject);
    }

    public function sortByApplicationID($data): array
    {
        $keys = array_keys($data);

        $compareFunction = function ($a, $b) {
            return $a['applicationID'] - $b['applicationID'];
        };

        usort($data, $compareFunction);
        $newArr = [];

        foreach ($data as $value) {
            $newArr[$value['name']] = $value;
        }

        $settingsIndex = array_search('settings', $keys);
        if ($settingsIndex) {
            $settingsData = $newArr['settings'];
            unset($newArr['settings']);
            $newArr['settings'] = $settingsData;
        }

        return $newArr;
    }


    public function setCookiesSessionToken(array $responseObject): void
    {
        $orderedMenu = Admin::sortMenusByDisplayOrder($responseObject['menus']);
        $applicationWiseSortedArray = $this->sortByApplicationID($orderedMenu);
        $processedMenuItems = array_map(function ($item) {
            return Admin::processMenuItem($item);
        }, $applicationWiseSortedArray);


        $userModel = config('aim-admin.auth.user_model', \App\Models\User::class);

        // Ensure the class exists and is valid
        if (!class_exists($userModel)) {
            throw new \InvalidArgumentException("The user model '{$userModel}' does not exist.");
        }

        $user = new $userModel;
        $user->id = $responseObject['userId'];
        $user->email = $responseObject['email'];
        $user->user_name = $responseObject['userName'];
        $user->full_name = $responseObject['fullName'];
        $user->phone_number = $responseObject['mobileNumber'];
        $user->is_successful = true;
        $user->remember_token = "";
        $user->isMustChangePassword = $responseObject["isMustChangePassword"];
        $user->created_at = $responseObject['createdAt'];

        session(['user' => $user]);

        $accessTokenExpiresAt = now()->addMinutes(60);
        //Set session values
        session(['apigw3_uid' => $responseObject['userId']]);
        session(['user_name' => $responseObject['userName']]);
        session(['access_token' => $responseObject['access_token']]);
        session(['access_token_expires_at' => $accessTokenExpiresAt]);
        session(['refresh_token' => $responseObject['refresh_token']]);
        session(['role' => $responseObject['roles']]);
        session(['roleids' => $this->userRoleIds($responseObject['roles'])]);
        session(['menus' => $processedMenuItems]);
        session(['applicationID' => $responseObject['applicationId']]);
        session(['profilePicID' => $responseObject['profilePicID']]);
        // Setting cookies
        Cookie::queue('access_token', $responseObject['access_token']);
        Cookie::queue('refresh_token', $responseObject['refresh_token']);
        // update User Application Map
        $this->updateUserApplicationMap($responseObject['userId']);
    }

    public function userRoleIds($roles): string
    {
        $ids = [];
        foreach ($roles as $role) {
            $ids[] = $role['id'];
        }
        if ($ids !== null) {
            return implode(" , ", $ids);
        }
        return '';
    }

    public function isAd(string $email): bool
    {
        $emailParts = Str::after($email, '@');
        return in_array($emailParts ?? [], config('aim-admin.auth.bl_domains'));
    }

    /**
     * @throws NotFoundException
     * @throws \Exception
     */
    public function requestAccessToken(string $email, string $password)
    {

        $postData = [
            'password' => $password,
            'scope' => config('aim-admin.auth.scope'),
            'userInfoRequired' => true
        ];

        if (Helper::isValidEmail($email)) {
            $grant_type = $this->isAd($email) ? "bl_active_directory" : "email_password";
            $postData['email'] = $email;
            $response = $this->getResponse($grant_type, $postData);
        } else {
            $postData['userName'] = $email;
            $response = $this->getResponse("email_password", $postData);
        }

        if (is_object($response) && property_exists($response, 'data')) {
            throw new \Exception('User Not Found.');
        }

        return $response;
    }


    /**
     * @throws \Exception
     */
    public function getResponse($grant_type, $postData)
    {
        try {
            $response = Http::authRequest()->withHeaders([
                'grant_type' => $grant_type,
            ])->post(AG3::AUTH_TOKEN, $postData);
            return json_decode($response->body());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function getTokenInfo(object $payload, string $item)
    {
        try {
            $accessToken = $payload->access_token;
            $parser = new Parser(new JoseEncoder());
            $token = $parser->parse($accessToken);
            return $token->claims()->get($item, false);
        } catch (\Exception $e) {
            throw new \Exception("Invalid token.");
        }
    }

    /**
     * @throws NotFoundException|GuzzleException
     */
    public function getUserPayload(object|string $accessToken, string $id, string $userEmail): array
    {
        $token = is_string($accessToken) ? $accessToken : $accessToken->access_token;

        $response = Http::requestWith($token)->get(AG3::GET_USER_PAYLOAD, [
            'id' => $id,
            'email' => $userEmail
        ]);

        $response = $response->body();
        // Decode JSON response into an associative array
        $responseArray = json_decode($response, true);

        return $this->userDataProcessing($responseArray, $token, $accessToken->refresh_token ?? null);
    }

    /**
     * @throws \Exception
     */
    public function createUserAGW3($email): string
    {
        $randomUserID = $this->generateUUID();
        $userName = explode("@", $email);
        $grant_type = $this->isAd($email) ? "bl_active_directory" : "email_password";
        $postData = [
            "userID" => $randomUserID,
            "userName" => $userName[0],
            "fullName" => $userName[0],
            "password" => ($grant_type == "email_password") ? Hash::make(\request('password')) : null,
            "emailAddress" => $email,
            "mobileNumber" => config('aim-admin.dev_user.mobile'),
            "createdBy" => config('aim-admin.auth.app_id'),
            "grantType" => $grant_type,
            "roleIDs" => null,
            "defaultApplicationID" => config('aim-admin.auth.app_id'),
            "permissionIDs" => null,
            "profilePicID" => null,
            "resetToken" => "",
            "PasswordResetContent" => "",
            "isMustChangePassword" => 0,
        ];
        $token = config('aim-admin.auth_token');
        try {
            $response = Http::requestWith($token)->post(AG3::SAVE_USER, $postData);
            if ($response->ok()) {
                $responseData = json_decode($response->body());
                if ($responseData->data == null) {
                    throw new RedirectWithErrorException("Unable to Create AD User. Getting Response data as null.");
                }
                return $responseData->data;
            }
        } catch (Exception $e) {
            throw new RedirectWithErrorException("Unable to Create AD User.");
        }
    }

    public function updateUserApplicationMap($id): void
    {
        $postData = [
            'userID' => $id,
            'applicationID' => config('aim-admin.auth.app_id')
        ];
        try {
            Http::request()->post(AG3::UPDATE_USER_APPLICATION_MAPPING, $postData);
        } catch (Exception $e) {
            //
        }
    }
}
