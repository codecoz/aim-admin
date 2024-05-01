<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

use CodeCoz\AimAdmin\Constants\AG3;
use CodeCoz\AimAdmin\Contracts\Service\PermissionServiceInterface;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use CodeCoz\AimAdmin\Repository\AbstractAimAdminRepository;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridLoaderInterface;

use CodeCoz\AimAdmin\Traits\APITrait;
use CodeCoz\AimAdmin\Traits\HelperTrait;

final class PermissionService extends AbstractAimAdminRepository implements PermissionServiceInterface, CrudGridLoaderInterface
{
    use APITrait, HelperTrait;

    public function getModelFqcn(): string
    {
        return '';
    }

    /**
     * @throws NotFoundException
     */
    public function getGridData(array $filters = []): iterable
    {

        return $this->getAllPermission();
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

    /**
     * @throws NotFoundException
     */
    public function filterPermissions()
    {
        $permissionData = $this->getAllPermission();
        $permissionData = collect($permissionData);
        $permissions = $permissionData->mapWithKeys(function ($item) {
            return [$item['id'] => $item['title']];
        });

        return $permissions->toArray();
    }

    /**
     * @throws NotFoundException
     */
    public function getAllPermission()
    {
        return $this->getPermissions();
    }

    public function getApplication(): array
    {
        return $this->getApplications();
    }

    /**
     * @throws NotFoundException
     */
    public function savePermission($request)
    {

        try {

            $postData = [
                "title" => $request->get('title'),
                "shortDescription" => $request->get('shortDescription'),
                "applicationID" => $request->get('applicationID'),
                "createdBy" => Auth::id(),
            ];

            $response = Http::request()->post(AG3::SAVE_PERMISSION, $postData);

            if ($response->ok()) {

                return true;

            } else {
                // Optionally log the error or handle unsuccessful response
                // Log::error("Failed to get single role", ['id' => $id, 'response' => $response->body()]);
                throw new NotFoundException("Error Saving Permissions. Status : " . $response->status());
            }
        } catch (NotFoundException $e) {
            // Handle or log exception as needed
            // Log::error("Exception in getSingleRole", ['id' => $id, 'message' => $e->getMessage()]);
            throw new NotFoundException("Error Saving Permissions.");
        }


    }

    /**
     * @throws NotFoundException
     */
    public function getSinglePermission(int $id)
    {

        try {

            $response = Http::request()->get(AG3::GET_SINGLE_PERMISSION, [
                'id' => $id
            ]);

            if ($response->ok()) {

                return json_decode($response->body());

            } else {
                // Optionally log the error or handle unsuccessful response
                // Log::error("Failed to get single role", ['id' => $id, 'response' => $response->body()]);
                throw new NotFoundException("Error retrieving single Permission. Status : " . $response->status());
            }
        } catch (NotFoundException $e) {
            // Handle or log exception as needed
            // Log::error("Exception in getSingleRole", ['id' => $id, 'message' => $e->getMessage()]);
            throw new NotFoundException("Error retrieving single Permission");
        }

    }

    /**
     * @throws NotFoundException
     */
    public function updatePermission($request)
    {

        try {

            $postData = [
                "permissionID" => $request->get('id'),
                "title" => $request->get('title'),
                "shortDescription" => $request->get('shortDescription'),
                "applicationID" => $request->get('applicationID'),
                "menus" => $request->get('menus'),
                "updatedBy" => Auth::id(),
            ];

            $response = Http::request()->post(AG3::SAVE_PERMISSION, $postData);

            if ($response->ok()) {

                return true;

            } else {
                // Optionally log the error or handle unsuccessful response
                // Log::error("Failed to get single role", ['id' => $id, 'response' => $response->body()]);
                throw new NotFoundException("Error updating Permission. Status : " . $response->status());
            }
        } catch (NotFoundException $e) {
            // Handle or log exception as needed
            // Log::error("Exception in getSingleRole", ['id' => $id, 'message' => $e->getMessage()]);
            throw new NotFoundException("Error updating Permission");
        }

    }

    public function deletePermission(int $id)
    {
        $response = Http::request()->get(AG3::DELETE_PERMISSION, [
            'id' => $id,
            'userID' => Auth::id(),
        ]);
        if ($response->ok()) {
            return true;
        }
        return false;
    }
}
