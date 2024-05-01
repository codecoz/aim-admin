<?php

namespace CodeCoz\AimAdmin\View\Components\Settings\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use CodeCoz\AimAdmin\Contracts\Service\PermissionServiceInterface;
use CodeCoz\AimAdmin\Traits\APITrait;


class PermissionComponent extends Component
{
    use APITrait;

    /**
     * Create a new component instance.
     */

    public function __construct(private readonly PermissionServiceInterface $permissionServiceInterface)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        $responseData = $this->getUserInformation(['extraPermissions', 'rolePermissions']);

        $permissions = $this->setToArray($responseData);
        return view('aimadmin::settings.user.permission-component')
            ->with('permissions', $permissions);

    }
}
