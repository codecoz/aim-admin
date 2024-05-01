<?php

namespace CodeCoz\AimAdmin\Http\Controllers;

use CodeCoz\AimAdmin\Contracts\Service\MenuServiceInterface;
use CodeCoz\AimAdmin\Contracts\Service\PermissionServiceInterface;
use CodeCoz\AimAdmin\Contracts\Service\RoleServiceInterface;
use CodeCoz\AimAdmin\Controller\AbstractAimAdminController;
use CodeCoz\AimAdmin\Field\Field;
use CodeCoz\AimAdmin\Field\ButtonField;
use CodeCoz\AimAdmin\Field\ChoiceField;
use CodeCoz\AimAdmin\Field\InputField;
use CodeCoz\AimAdmin\Field\TextField;
use CodeCoz\AimAdmin\Http\Requests\RoleStoreRequest;
use CodeCoz\AimAdmin\Http\Requests\RoleUpdateRequest;

class RoleController extends AbstractAimAdminController
{
    public function __construct(private readonly RoleServiceInterface $roleService, private readonly PermissionServiceInterface $permissionService, private readonly MenuServiceInterface $menuServiceInterface)
    {
    }
    public function getRepository()
    {
        return $this->roleService;
    }


    public function configureActions(): iterable
    {

        return [
            ButtonField::init('new', 'new')->linkToRoute('role_create')->createAsCrudBoardAction(),
            ButtonField::init(ButtonField::EDIT)->linkToRoute('role_edit', function ($row) {
                return ['id' => $row['id']];
            })->setLabel('Edit Role')->setCssClass('btn btn-warning'),
            ButtonField::init(ButtonField::EDIT)->linkToRoute('role_edit_role_permission', function ($row) {
                return ['id' => $row['id']];
            })->setLabel('Edit Role Permission')->setCssClass('btn btn-info'),
            ButtonField::init(ButtonField::EDIT)->linkToRoute('role_edit_menu_permission', function ($row) {
                return ['id' => $row['id']];
            })->setLabel('Edit Menu Permission')->setCssClass('btn btn-primary'),
            ButtonField::init(ButtonField::DELETE)->linkToRoute('role_delete', function ($row) {
                return ['id' => $row['id']];
            }),
            ButtonField::init('submit')->createAsFormSubmitAction(),
            ButtonField::init('cancel')->linkToRoute('role_list')->createAsFormAction(),
        ];
    }

    public function configureForm()
    {
        $type = request()->attributes->get('type');

        $fields = [
            ChoiceField::init('applicationID', 'Select Application', choiceType: 'select', choiceList: $this->roleService->getApplication())->setCssClass('my-class'),
            InputField::init('title')->setHtmlAttributes(['required' => true, 'minlength' => 3]),
            InputField::init('shortDescription', 'Short Description', 'textarea')->setHtmlAttributes(['required' => true, 'minlength' => 3]),
        ];

        if ($type == 'menu') {
            $fields[] = [InputField::init('menus')->setComponent('aimadmin::settings.role.menu-component')->setHtmlAttributes(['required' => true, 'minlength' => 8])->setLayoutClass('col-md-12')];
        }

        if ($type == 'role') {
            $fields[] = [InputField::init('roles')->setComponent('aimadmin::settings.role.role-component')->setHtmlAttributes(['required' => true, 'minlength' => 8])->setLayoutClass('col-md-12')];
        }

        $this->getForm($fields)
            ->setName('role_form')
            ->setMethod('post')
            ->setActionUrl(route('role_store'));
    }

    public function configureFilter(): void
    {
        $fields = [
            TextField::init('title'),
            TextField::init('name'),
            TextField::init('shortDescription'),
        ];
        $this->getFilter($fields);
    }

    public function role()
    {
        $this->initGrid([
            'title',
            'name',
            Field::init('shortDescription', 'Short Description'),
            Field::init('isActive', 'Active Status')->formatValue(function ($value) {
                return $value == 1 ? "Active" : "Inactive";
            }),
            Field::init('isDeleted', 'Is Deleted')->formatValue(function ($value) {
                return $value == 1 ? "Yes" : "No";
            }),
        ], pagination: 10);
        return view('aimadmin::list')->with('pageTitle', 'Role List');
    }

    public function store(RoleStoreRequest $request)
    {
        $this->roleService->saveRole($request);
        return to_route('role_list')->with('success', 'Role Created Successfully !');
    }

    public function create()
    {
        $this->initCreate();
        return view('aimadmin::create')->with('pageTitle', 'Create Role');
    }

    public function update(RoleUpdateRequest $request)
    {
        $this->roleService->updateRole($request);
        return redirect()->route('role_list')->with('success', 'Updated Successfully !');
    }

    public function delete(int $id)
    {
        $this->roleService->deleteRole($id);
        return redirect('role')->with('success', 'Role Deleted Successfully !');
    }

    /**
     * @throws \Exception
     */
    public function edit($id)
    {
        $menuFromAllApplication = $this->menuServiceInterface->getAllMenu();

        $menu = $menuFromAllApplication;

        $singleRole = $this->roleService->getSingleRole($id);

        if ($singleRole->data == null) {
            return redirect()->back()->with(['error' => 'Single Role not found !']);
        }

        return view('aimadmin::settings.role.edit-role')->with('role', $singleRole->data)
            ->with('userApplicationIDs', $this->roleService->getApplication())
            ->with('menus', $menu);
    }

    /**
     * @throws \Exception
     */
    public function menuPermissionEdit($id)
    {
        request()->attributes->set('type', 'menu');

        $menuFromAllApplication = $this->menuServiceInterface->getAllMenu();

        $menu = $menuFromAllApplication;

        $singleRole = $this->roleService->getSingleRole($id);

        if ($singleRole->data == null) {
            return redirect()->back()->with(['error' => 'Single Role not found.']);
        }

        return view('aimadmin::settings.role.edit-menu-permission')->with('role', $singleRole->data)
            ->with('userApplicationIDs', $this->roleService->getApplication())
            ->with('menus', $menu);
    }

    /**
     * @throws \Exception
     */
    public function rolePermissionEdit($id)
    {
        request()->attributes->set('type', 'role');

        $permissions = $this->permissionService->filterPermissions();

        $singleRole = $this->roleService->getSingleRole($id);

        if ($singleRole->data == null) {
            return redirect()->back()->with(['error' => 'Single Role not found !']);
        }

        return view('aimadmin::settings.role.edit-role-permission')->with('role', $singleRole->data)
            ->with('userApplicationIDs', $this->roleService->getApplication())
            ->with('permissions', $permissions);
    }
}
