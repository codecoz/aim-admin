<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

use CodeCoz\AimAdmin\Constants\AG3;
use CodeCoz\AimAdmin\Contracts\Service\UserGroupServiceInterface;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use CodeCoz\AimAdmin\Repository\AbstractAimAdminRepository;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridLoaderInterface;
use CodeCoz\AimAdmin\Traits\APITrait;
use CodeCoz\AimAdmin\Traits\HelperTrait;

final class UserGroupService extends AbstractAimAdminRepository implements UserGroupServiceInterface, CrudGridLoaderInterface
{
    use APITrait, HelperTrait;

    public function getModelFqcn(): string
    {
        return '';
    }

    public function getGridData(array $filters = []): iterable
    {
        $userGroupData = $this->getAllUserGroup(true);
        $userGroups = $userGroupData['data'] ?? [];
        return $this->setToArray($userGroups);

    }

    public function applyFilterData(Collection $data, array $filters): Collection
    {
        foreach ($filters as $field => $value) {
            if ($value !== null) {
                $data = $data->filter(function ($item) use ($field, $value) {
                    return stripos($item[$field], $value) !== false;
                });
            }
        }
        return $data;
    }

    public function getAllUserGroup($array = false)
    {
        $response = Http::request()->get(AG3::GET_USER_GROUPS, [
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

    public function saveUserGroup($request): bool
    {
        $postData = [
            "name" => $request->get('name'),
            "applicationID" => config('aim-admin.auth.app_id'),
            "createdBy" => Auth::id(),
        ];
        try {

            $response = Http::request()->post(AG3::SAVE_USER_GROUP, $postData);

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
    public function getSingleUserGroup(int $id)
    {
        try {
            $response = Http::request()->get(AG3::GET_USER_GROUP, ['Id' => $id]);
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
    public function updateUserGroup($request)
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

    public function deleteUserGroup(int $id)
    {
        $response = Http::request()->get(AG3::DELETE_USER_GROUP, [
            'ID' => $id,
            'deletedBy' => Auth::id(),
        ]);
        if ($response->ok()) {
            return true;
        }
        return false;

    }

}
