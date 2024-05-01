<?php

namespace CodeCoz\AimAdmin\View\Components\Settings\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Session;
use CodeCoz\AimAdmin\Contracts\Service\MenuServiceInterface;
use CodeCoz\AimAdmin\Traits\APITrait;
use CodeCoz\AimAdmin\Traits\HelperTrait;

class RoleCustomComponent extends Component
{
    use HelperTrait, APITrait;

    /**
     * Create a new component instance.
     */
    public function __construct(private MenuServiceInterface $menuService)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $menuFromAllApplication = $this->menuService->getAllMenu();
        $menus = Session::get('applicationID') == config('aim-admin.core_application_id') ? $menuFromAllApplication : $this->menuService->getAllMergedMenuForUser(Session::get('applicationID'), $this->setToArray($this->getUserInformation(['menu'])));

        return view('aimadmin::settings.user.role-custom-component')
            ->with('menus', $menus);
    }
}
