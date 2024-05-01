<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use CodeCoz\AimAdmin\Constants\AG3;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use CodeCoz\AimAdmin\Contracts\Service\UserServiceInterface;
use CodeCoz\AimAdmin\Repository\AbstractAimAdminRepository;
use CodeCoz\AimAdmin\Traits\APITrait;
use CodeCoz\AimAdmin\Traits\AttachmentUploadTrait;
use CodeCoz\AimAdmin\Traits\HelperTrait;

final class UserService extends AbstractAimAdminRepository implements UserServiceInterface
{
    use APITrait, HelperTrait, AttachmentUploadTrait;

    public function getModelFqcn(): string
    {
        return '';
    }

    public function getGridData(array $filters = []): ?iterable
    {
        $userData = $this->getAllUser();
        $users = collect($userData->data ?? []);
        $users->map(function ($user) {
            if (config('aim-admin.core_application_id') != $this->sessionCheck('applicationID')) {
                return $user;
            } else {
                if (!$user->isDeleted)
                    return $user;
            }
        });
        return $this->setToArray($users->toArray());
    }

    public function applyFilterData(Collection $data, array $filters): Collection
    {
        $user = $data->map(function ($user) {
            if (config('aim-admin.core_application_id') != $this->sessionCheck('applicationID')) {
                return $user;
            } else {
                if (!$user['isDeleted']) {
                    return $user;
                }
            }
        });

        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $user = $user->filter(function ($item) use ($field, $value) {
                    if (isset($item[$field])) {
                        return stripos($item[$field], $value) !== false;
                    }
                    return false;
                });
            }
        }
        return $user;
    }

    /**
     * @return array all user's
     */
    public function getAllUser($array = false)
    {
        $response = Http::request()->get(AG3::APP_USERS, [
            'id' => config('aim-admin.auth.app_id')
        ]);
        if ($response->ok()) {
            $response = $response->body();
            return json_decode($response, $array);
        }
        return [];
    }

    /**
     * @param string $id auth user id or specific id
     * @return mixed $response with user information
     * @throws NotFoundException
     */
    public function getSingleUser(string $id, $array = false)
    {
        try {
            $response = Http::request()->get(AG3::GET_USER_PAYLOAD,
                ['id' => $id]
            );
            if ($response->ok()) {
                $response = $response->body();
                return json_decode($response, $array);
            }
            throw new NotFoundException("Getting status : " . $response->status());
        } catch (NotFoundException $exception) {
            throw new NotFoundException($exception->getMessage());
        }
    }

    public function userApplicationID()
    {
        return $this->sessionCheck('applicationID');
    }

    public function getApplication()
    {
        return $this->getApplications();
    }

    public function getAllUserIDNameArr(): array
    {
        $userListArr = array();
        $userData = $this->getAllUser();
        $users = $userData->data ?? [];
        foreach ($users as $user) {
            $userListArr[$user->userID] = $user->userName . '(' . $user->emailAddress . ')';
        }
        return $userListArr;
    }

    /**
     * @throws NotFoundException
     */
    public function getApplicationName(int $id): mixed
    {
        $applicationIDs = $this->getApplications();
        foreach ($applicationIDs as $key => $value) {
            return $value;
        }
        throw new NotFoundException('No Application Found');
    }

    public function getRoles(): array
    {
        return $this->roles();
    }

    public function dataParseFromArr(array $item, string $name): array
    {
        if (isset($item[$name])) {
            return $this->getSingleValueFromArr($item, $name);
        }

        return [];
    }

    /**
     * @return mixed could be true or 404
     */
    public function saveUser($request): bool
    {
        $resetToken = Str::random(75);
        $randomUserID = $this->generateUUID();
        $imageID = $request->file('image') == null ? '' : $this->upload($request->file('image'));
        $isActive = ($request->get('GrantType') == 'bl_active_directory') ? 0 : 1;
        $password = ($request->get('GrantType') == 'bl_active_directory' && $request->get('GrantType') != null) ? null : $request->get('password');
        $postData = [
            "userID" => $randomUserID,
            "userName" => $request->get('userName'),
            "fullName" => $request->get('fullName'),
            "password" => $password,
            "emailAddress" => $request->get('emailAddress'),
            "mobileNumber" => $request->get('mobileNumber'),
            "createdBy" => Auth::id(),
            "grantType" => $request->get('GrantType'),
            "roleIDs" => $request->get('roles'),
            "defaultApplicationID" => (int)$request->get('applicationID'),
            "permissionIDs" => $request->get('permissions') ?? null,
            "profilePicID" => $imageID,
            "resetToken" => $resetToken,
            "PasswordResetContent" => $this->getResetHtmlContent($resetToken),
            "isMustChangePassword" => $isActive,
        ];
        $response = Http::request()->post(AG3::SAVE_USER, $postData);
        if ($response->ok()) {
            return true;
        }
        return false;
    }

    public function updateUser($request): bool
    {
        $imageID = $request->file('image') == null ? $request->get('old_image') : $this->upload($request->file('image'));
        $isActive = $request->has('isActiveUser') ? 1 : 0;
        $password = ($request->get('GrantType') == 'bl_active_directory' && $request->get('GrantType') != null) ? null : $request->get('password');

        $postData = [
            "userID" => $request->get('id'),
            "userName" => $request->get('userName'),
            "fullName" => $request->get('fullName'),
            "password" => $password,
            "emailAddress" => $request->emailAddress,
            "mobileNumber" => $request->get('mobileNumber'),
            "isUserActive" => $isActive,
            "roleIDs" => $request->get('roles'),
            "updatedBy" => Auth::id(),
            "permissionIDs" => $request->get('permissions'),
            "profilePicID" => $imageID,
        ];
        $response = Http::request()->post(AG3::UPDATE_APP_USER, $postData);
        if ($response->ok()) {
            return true;
        }
        return false;
    }

    public function deleteUser(string $id)
    {
        $response = Http::request()->get(AG3::DELETE_USER, [
            'id' => config('aim-admin.auth.app_id'),
            'userID' => Auth::id(),
        ]);
        if ($response->ok()) {
            return true;
        }
        return false;
    }


    public function updateUserPassword($request): bool
    {
        $userId = $request->id ?? Auth::id();

        $postData = [
            "userID" => $userId,
            "password" => $request->get('password'),
        ];

        $response = Http::request()->post(AG3::UPDATE_USER_PASSWORD, $postData);

        if ($response->ok()) {
            return true;
        }

        return false;
    }

    /**
     * @throws NotFoundException
     */
    public function userOldPasswordCheck(string $oldPassword): bool|\Exception
    {
        $userPassword = $this->getSingleUser(Auth::id());
        return ($userPassword->data->password == $oldPassword) ? true : throw new NotFoundException('Password is not same as old password');
    }

}
