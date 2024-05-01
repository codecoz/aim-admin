<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

use CodeCoz\AimAdmin\Constants\AG3;
use CodeCoz\AimAdmin\Contracts\Service\RoleServiceInterface;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use CodeCoz\AimAdmin\Repository\AbstractAimAdminRepository;
use CodeCoz\AimAdmin\Contracts\Service\CrudBoard\CrudGridLoaderInterface;
use CodeCoz\AimAdmin\Traits\APITrait;
use CodeCoz\AimAdmin\Traits\HelperTrait;

final class RoleService extends AbstractAimAdminRepository implements RoleServiceInterface, CrudGridLoaderInterface
{
    use APITrait, HelperTrait;

    public function getModelFqcn(): string
    {
        return '';
    }

    public function getGridData(array $filters = []): iterable
    {
        return $this->setToArray($this->getAllRole());

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

    public function getAllRole()
    {
        $response = Http::request()->get(AG3::APP_ROLES, [
            'id' => config('aim-admin.auth.app_id')
        ]);
        if ($response->ok()) {
            return $response->json()['data'];
        }
        return [];
    }

    public function getApplication(): array
    {
        return $this->getApplications();
    }

    /**
     * @return mixed could be true or throws exception
     * @throws NotFoundException
     */
    public function saveRole($request): bool
    {
        $postData = [
            "title" => $request->get('title'),
            "shortDescription" => $request->get('shortDescription'),
            "applicationID" => $request->get('applicationID'),
            "menus" => $request->get('menus') ?? null,
            "createdBy" => Auth::id(),
        ];
        try {

            $response = Http::request()->post(AG3::APP_ROLE, $postData);

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
    public function getSingleRole(int $id)
    {
        try {

            $response = Http::request()->get(AG3::APP_ROLE, ['id' => $id]);

            if ($response->ok()) {
                return json_decode($response->body());
            } else {
                // Optionally log the error or handle unsuccessful response
                // Log::error("Failed to get single role", ['id' => $id, 'response' => $response->body()]);
                throw new NotFoundException("Error retrieving role with ID: $id");
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
    public function updateRole($request)
    {
        $postData = [
            "roleID" => $request->get('id'),
            "title" => $request->get('title'),
            "shortDescription" => $request->get('shortDescription'),
            "applicationID" => $request->get('applicationID'),
            "menus" => $request->get('menus') ?? null,
            "permissions" => $request->get('permissions') ?? null,
            "updatedBy" => Auth::id(),
        ];

        try {

            $response = Http::request()->post(AG3::APP_ROLE_UPDATE, $postData);

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

    public function deleteRole(int $id)
    {
        $response = Http::request()->get(AG3::DELETE_APP_ROLE, [
            'id' => $id,
            'userID' => Auth::id(),
        ]);
        if ($response->ok()) {
            return true;
        }
        return false;

    }

}
