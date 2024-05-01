<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

use CodeCoz\AimAdmin\Constants\AG3;
use CodeCoz\AimAdmin\Contracts\Service\UserGroupMapServiceInterface;
use CodeCoz\AimAdmin\Contracts\Service\UserGroupServiceInterface;
use CodeCoz\AimAdmin\Contracts\Service\UserServiceInterface;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use CodeCoz\AimAdmin\Repository\AbstractAimAdminRepository;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridLoaderInterface;
use CodeCoz\AimAdmin\Traits\APITrait;
use CodeCoz\AimAdmin\Traits\HelperTrait;

final class UserGroupMapService extends AbstractAimAdminRepository implements UserGroupMapServiceInterface, CrudGridLoaderInterface
{
    use APITrait, HelperTrait;


    function __construct(private readonly UserServiceInterface      $userService,
                         private readonly UserGroupServiceInterface $userGroupService)
    {

    }

    public function getModelFqcn(): string
    {
        return '';
    }

    public function getGridData(array $filters = []): iterable
    {
        $userGroupData = $this->userGroupService->getAllUserGroup(true);
        $userGroups = $userGroupData['data'] ?? [];
        $groups = collect($userGroups)->pluck('name', 'ID')->toArray();
        $userGroupMapData = $this->getAllUserGroupMap(true);
        $userMapGroups = $userGroupMapData['data'] ?? [];
        $userData = $this->userService->getAllUser(true);
        $users = $userData['data'] ?? [];
        $users = collect($users)->pluck('fullName', 'userID')->toArray();
        $list = [];
        foreach ($userMapGroups as $userGroup) {
            $userGroup['userName'] = '';
            $userGroup['groupName'] = '';
            if (array_key_exists($userGroup['userID'], $users)) {
                $userGroup['userName'] = $users[$userGroup['userID']];
            }
            if (array_key_exists($userGroup['groupID'], $groups)) {
                $userGroup['groupName'] = $groups[$userGroup['groupID']];
            }
            $list[] = $userGroup;
        }

        return $list;
    }

    public function applyFilterData(Collection $data, array $filters): Collection
    {
        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $data = $data->filter(function ($item) use ($field, $value) {
                    return $item[$field] !== null && stripos((string)$item[$field], (string)$value) !== false;
                });
            }
        }
        return $data;
    }

    public function getAllUserGroupMap($array = false)
    {
        $response = Http::request()->get(AG3::GET_USER_GROUP_MAPS, [
            'id' => config('aim-admin.auth.app_id')
        ]);
        if ($response->ok()) {
            $response = $response->body();
            return json_decode($response, $array);
        }
        return [];
    }

    /**
     * @return mixed could be true or throws exception
     * @throws NotFoundException
     */

    public function saveUserGroupMap($request): bool
    {
        $postData = [
            "userID" => $request->get('user_id'),
            "groupID" => $request->get('group_id'),
            "applicationID" => config('aim-admin.auth.app_id'),
            "createdBy" => Auth::id(),
        ];
        try {

            $response = Http::request()->post(AG3::SAVE_USER_GROUP_MAP, $postData);

            if ($response->ok()) {
                return true;
            } else {
                // Optionally log the error or handle unsuccessful response
                // Log::error("Failed to get single role", ['id' => $id, 'response' => $response->body()]);
                throw new NotFoundException("Error saving role");
            }
        } catch (NotFoundException $e) {
            // Handle or log exception as needed
            // Log::error("Exception in getSingleRole", ['id' => $id, 'message' => $e->getMessage()]);
            throw new NotFoundException($e->getMessage());
        }
    }

    /**
     * @throws NotFoundException
     */
    public function getSingleUserGroupMap(int $id)
    {
        try {

            $response = Http::request()->get(AG3::GET_USER_GROUP_MAP_BY_ID, ['Id' => $id]);

            if ($response->ok()) {
                return json_decode($response->body());
            } else {
                // Optionally log the error or handle unsuccessful response
                // Log::error("Failed to get single role", ['id' => $id, 'response' => $response->body()]);
                throw new NotFoundException("Error retrieving UserGroup with ID: $id");
            }
        } catch (NotFoundException $e) {

            // Handle or log exception as needed
            // Log::error("Exception in getSingleRole", ['id' => $id, 'message' => $e->getMessage()]);
            throw new NotFoundException($e->getMessage());
        }
    }

    /**
     * @throws NotFoundException
     */
    public function updateUserGroupMap($request)
    {
        $postData = [
            "ID" => $request->get('id'),
            "name" => $request->get('name'),
            "updatedBy" => Auth::id(),
        ];

        try {

            $response = Http::request()->post(AG3::UPDATE_USER_GROUP, $postData);

            if ($response->ok()) {
                return true;
            } else {
                // Optionally log the error or handle unsuccessful response
                // Log::error("Failed to get single role", ['id' => $id, 'response' => $response->body()]);
                throw new NotFoundException("Error updating role with ID: $request->get('id')");
            }
        } catch (NotFoundException $e) {
            // Handle or log exception as needed
            // Log::error("Exception in getSingleRole", ['id' => $id, 'message' => $e->getMessage()]);
            throw new NotFoundException($e->getMessage());
        }
    }

    public function deleteUserGroupMap(int $id)
    {
        $response = Http::request()->get(AG3::DELETE_USER_GROUP_MAP, [
            'ID' => $id,
        ]);
        if ($response->ok()) {
            return true;
        }
        return false;
    }
}
