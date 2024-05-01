<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use CodeCoz\AimAdmin\Constants\AG3;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;

trait HelperTrait
{
    /**
     * If Session value exits it return value else logout the user.
     */
    private function sessionCheck(string $value)
    {
        return Session::get($value);
    }

    public function checkIfExitsApplication(int $id): bool
    {
        return $this->sessionCheck('applicationID') == $id;
    }

    /**
     * @return array of role
     */
    public function roles()
    {
        return $this->setToArray($this->sessionCheck('role'));
    }

    //Set To Array
    public function setOnlyArray($set): array
    {
        $permissions = $this->setToArray($set);

        $newPermissionArr = array();
        foreach ($permissions as $item) {
            $newPermissionArr[] = $item['name'];
        }
        return $newPermissionArr;
    }


    public function setToArray(array $items): array
    {
        return array_map(function ($item) {
            return (array)$item;
        }, $items);
    }

    /**
     * @return array array set from parse data eg: role, permission, menu in User Class & etc.
     */
    public function getSingleValueFromArr(array $data, string $name): array
    {
        $itemArray = array();
        foreach ($data[$name] as $item) {
            $itemArray[] = $item->id;
        }
        return $itemArray;
    }

    /**
     * @return array of application having id-name pair
     */
    public function getMultiValueFromArr(array $data): array
    {
        $itemArr = array();
        foreach ($data as $item) {
            $itemArr[$item->applicationID] = $item->applicationName;
        }
        return $itemArr;
    }

    /**
     * @return array return menu parent child relation
     */
    public function parentChildMenuItem(array $menu, $parentId = null)
    {
        $result = [];
        foreach ($menu as $item) {
            if ($item['parentID'] == $parentId) {
                $children = $this->parentChildMenuItem($menu, $item['id']);

                $item['children'] = !empty($children) ? $children : [];

                $result[$item['name']] = $item;
            }
        }
        return $result;
    }

    /**
     * @param array $hayStack
     * @param mixed $identifier could be null or key value to get eg: [1=>[],'sting'=>[]]
     * @return array return Set of feature
     */
    private function getFeatSets(array $hayStack, mixed $identifier): array
    {
        $result = array();
        foreach ($hayStack as $value) {
            if ($identifier == null) {
                $result[] = $value;
            } else {
                $result[$value[$identifier]] = $value;
            }
        }
        return $result;
    }

    /**
     */
    public function menuKeypair(array $data): array
    {
        $newParentID = array();
        foreach ($data as $menu) {
            $newParentID[$menu['id']] = $menu['title'];
        }
        return $newParentID;
    }

    public function userDataProcessing($userArray, string $access, string $refresh = null): array
    {
        $data['userId'] = data_get($userArray, 'data.userID');
        $data['email'] = data_get($userArray, 'data.emailAddress');
        $data['userName'] = data_get($userArray, 'data.userName');
        $data['fullName'] = data_get($userArray, 'data.fullName');
        $data['mobileNumber'] = data_get($userArray, 'data.mobileNumber');
        $data['isMustChangePassword'] = data_get($userArray, 'data.isMustChangePassword');
        $data['menus'] = $this->parentChildMenuItem($this->getFeatSets(data_get($userArray, 'data.menus'), 'name'));
        $data['roles'] = $this->getFeatSets(data_get($userArray, 'data.roles'), 'name');
        $data['applicationId'] = data_get($userArray, 'data.applicationID');
        $data['isMustPasswordChange'] = data_get($userArray, 'data.isMustChangePassword') == 1;
        $data['profilePicID'] = data_get($userArray, 'data.profilePicID');
        $data['createdAt'] = data_get($userArray, 'data.createdAt');
        $data['access_token'] = $access;
        $data['refresh_token'] = $refresh;

        return $data;
    }

    public function getApplications()
    {
        $applicationID = config('aim-admin.auth.app_id');
        $response = Http::request()->get(AG3::GET_APPLICATIONS);
        if ($response->ok()) {
            $applicationArray = $this->getMultiValueFromArr(json_decode($response->body())->data);
            $singleApplication[$applicationID] = $applicationArray[$applicationID];
        }

        return ($applicationID == config('aim-admin.core_application_id')) ? $applicationArray : $singleApplication;
    }

    /**
     * @throws NotFoundException
     */
    public function getPermissions()
    {
        try {
            $response = Http::request()->get(AG3::GET_ALL_PERMISSIONS, [
                'id' => config('aim-admin.auth.app_id')
            ]);
            if ($response->ok()) {
                $data = json_decode($response->body());
                return $this->setToArray($data->data);
            } else {
                // Optionally log the error or handle unsuccessful response
                // Log::error("Failed to get single role", ['id' => $id, 'response' => $response->body()]);
                throw new NotFoundException("Error retrieving Permissions. Status : " . $response->status());
            }
        } catch (NotFoundException $e) {
            // Handle or log exception as needed
            // Log::error("Exception in getSingleRole", ['id' => $id, 'message' => $e->getMessage()]);
            throw new NotFoundException("Error retrieving Permissions.");
        }
    }


    public function generateUUID(): string
    {
        return (string)Str::orderedUuid();
    }

    public function getApplictionId(): int
    {
        return $this->sessionCheck('applicationID');
    }

    public function getTotalListItem(array|object $userInformation, array $listOfItem): array
    {
        $excludeItems = [];
        foreach ($userInformation as $userItem) {
            if ($userItem->applicationID && $userItem->applicationID != Session::get('applicationID')) {
                $excludeItems[] = (array)$userItem;
            }
        }
        $result = array_merge($excludeItems, $listOfItem);
        return array_values(array_intersect_key($result, array_unique(array_column($result, 'id'))));
    }

    public function getResetHtmlContent($resetToken)
    {
        $htmlContent = view('aimadmin::auth.reset-view', compact('resetToken'))->render();
        return json_encode(['html_content' => $htmlContent]);
    }

    public function checkPermission($permission): bool
    {
        $response = Http::request()->get(AG3::GET_USER_PERMISSION, [
            'id' => Auth::id(),
            'roles' => $this->sessionCheck('roleids'),
            'permission' => $permission
        ])->body();

        return json_decode($response)->data == 'true';
    }

    public function getUserByRole($data)
    {
        $newRoleUserSet = [];
        foreach ($data as $key => $value) {
            $newRoleUserSet[$value['name']] = $value['userEmail'];
        }
        return $newRoleUserSet;
    }
}
