<?php

namespace CodeCoz\AimAdmin\Contracts\Service;

use Illuminate\Http\Request;

interface LoginServiceInterface
{
    function userLogin(Request $request);

    function tokenGenerationSetCookie(string $email, string $password);

    function setCookiesSessionToken(array $responseObject);

    function requestAccessToken(string $email, string $password);

    function getTokenInfo(object $payload, string $item);

    function getUserPayload(object|string $accessToken, string $id, string $userEmail);

    function createUserAGW3($email);
}
