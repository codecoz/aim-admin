<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

use CodeCoz\AimAdmin\Constants\AG3;
use CodeCoz\AimAdmin\Exceptions\NotFoundException;
use CodeCoz\AimAdmin\Contracts\Service\MenuServiceInterface;
use CodeCoz\AimAdmin\Helpers\Helper;
use CodeCoz\AimAdmin\Repository\AbstractAimAdminRepository;
use CodeCoz\AimAdmin\Traits\APITrait;
use CodeCoz\AimAdmin\Traits\HelperTrait;

final class MenuService extends AbstractAimAdminRepository implements MenuServiceInterface
{
    use APITrait, HelperTrait;

    /**
     * @throws NotFoundException
     */
    public function getGridData(array $filters = []): iterable
    {
        return $this->getAllMenu();
    }

    /**
     * @throws NotFoundException
     */
    public function getAllMenu(): array
    {
        $response = Http::request()->get(AG3::APP_MENUS, [
            'id' => config('aim-admin.auth.app_id')
        ]);
        if ($response->ok()) {
            return $this->setToArray(json_decode($response->body())->data);
        }
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
     * @return null|array menu item by userid.
     */
    public function getMenuByID(): mixed
    {
        $response = Http::request()->get(AG3::GET_USER_PAYLOAD, [
            'id' => Auth::id(),
            'email' => 'null',
        ]);
        return $this->setToArray($response->data->menus);
    }

    public function getApplication(): array
    {
        return $this->getApplications();
    }

    public function singleMenu(int $id): \stdClass
    {
        $response = Http::request()->get(AG3::APP_MENU, [
            'id' => $id
        ]);

        if ($response->ok()) {
            return json_decode($response->body());
        }

        // Return an empty \stdClass instance if the response is not OK
        return new \stdClass();
    }


    public function getModelFqcn(): string
    {
        return '';
    }


    public function saveMenu($request): bool
    {
        $name = Helper::generateSlug($request->get('name'));

        $postData = [
            "applicationID" => $request->get('applicationID'),
            "title" => $request->get('title'),
            'name' => $name,
            "iconName" => $request->get('iconName'),
            "displayOrder" => $request->get('display_order'),
            "target" => $request->get('target'),
        ];

        $postData['createdBy'] = Auth::id();

        if ($request->get('parentID') != -1) {
            $postData['parentID'] = $request->get('parentID');
        }

        $response = Http::request()->post(AG3::SAVE_APP_MENU, $postData);

        if ($response->ok()) {
            return true;
        }
        return false;
    }

    public function updateMenu($request): bool
    {
        $name = Helper::generateSlug($request->get('name'));

        $postData = [
            "applicationID" => $request->get('applicationID'),
            "title" => $request->get('title'),
            'name' => $name,
            "iconName" => $request->get('iconName'),
            "displayOrder" => $request->get('display_order'),
            "target" => $request->get('target'),
        ];

        $postData['menuID'] = $request->get('id');
        $postData['updatedBy'] = Auth::id();

        if ($request->get('parentID') != -1) {
            $postData['parentID'] = $request->get('parentID');
        }

        $response = Http::request()->post(AG3::UPDATE_APP_MENU, $postData);
        if ($response->ok()) {
            return true;
        }
        return false;
    }

    public function deleteMenu(string $id)
    {
        $response = Http::request()->get(AG3::DELETE_APP_MENU, [
            'id' => $id,
            'userID' => Auth::id(),
        ]);
        if ($response->ok()) {
            return true;
        }
        return false;
    }

    /**
     * @throws NotFoundException
     */
    public function keyPairParentID(): array
    {
        return $this->menuKeypair($this->getAllMenu());
    }

    /**
     * @throws NotFoundException
     */
    public function getMenuByApplicationID(int $applicationID): array
    {
        $allApplicationMenu = $this->getAllMenu();
        $applicationByMenu = [];
        foreach ($allApplicationMenu as $value) {
            if ($value['applicationID'] == $applicationID) {
                $applicationByMenu[] = $value;
            }
        }

        return $applicationByMenu;
    }

    public function getOtherAppMenuAddedByAdminToUser($userMenu, $applicationID): array
    {
        $excludedMenu = [];
        foreach ($userMenu as $key => $value) {
            if ($value['applicationID'] != $applicationID) {
                $excludedMenu[] = $value;
            }
        }
        return $excludedMenu;
    }

    /**
     * @throws NotFoundException
     */
    public function getAllMergedMenuForUser(int $applicationID, array $userMenu): array
    {
        return array_merge($this->getMenuByApplicationID($applicationID), $this->getOtherAppMenuAddedByAdminToUser($userMenu, $applicationID));
    }
}
