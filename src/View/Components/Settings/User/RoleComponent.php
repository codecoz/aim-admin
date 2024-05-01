<?php

namespace CodeCoz\AimAdmin\View\Components\Settings\User;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use CodeCoz\AimAdmin\Contracts\Service\RoleServiceInterface;

class RoleComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(private readonly RoleServiceInterface $roleServiceInterface)
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('aimadmin::settings.user.role-component')->with('roles', $this->roleServiceInterface->getAllRole());
    }
}
