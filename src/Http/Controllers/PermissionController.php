<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Http\Controllers;

use CodeCoz\AimAdmin\Contracts\Service\PermissionServiceInterface;
use CodeCoz\AimAdmin\Controller\AbstractAimAdminController;
use CodeCoz\AimAdmin\Field\ButtonField;
use CodeCoz\AimAdmin\Field\ChoiceField;
use CodeCoz\AimAdmin\Field\Field;
use CodeCoz\AimAdmin\Field\InputField;
use CodeCoz\AimAdmin\Field\TextField;
use CodeCoz\AimAdmin\Http\Requests\PermissionStoreRequest;
use CodeCoz\AimAdmin\Http\Requests\PermissionUpdateRequest;

class PermissionController extends AbstractAimAdminController
{
    private PermissionServiceInterface $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function getRepository()
    {
        return $this->permissionService;
    }

    public function configureActions(): iterable
    {

        return [
            ButtonField::init('new', 'new')->linkToRoute('permission_create')->createAsCrudBoardAction(),
            ButtonField::init(ButtonField::EDIT)->linkToRoute('permission_edit', function ($row) {
                return ['id' => $row['id']];
            }),
            ButtonField::init(ButtonField::DELETE)->linkToRoute('permission_delete', function ($row) {
                return ['id' => $row['id']];
            }),
            ButtonField::init('submit')->createAsFormSubmitAction(),
            ButtonField::init('cancel')->linkToRoute('permission_list')->createAsFormAction(),
        ];

    }

    public function configureForm()
    {
        $fields = [
            ChoiceField::init('applicationID', 'Select Application', choiceType: 'select', choiceList: $this->permissionService->getApplication()),
            InputField::init('title')->setHtmlAttributes(['required' => true]),
            InputField::init('shortDescription', 'Short Description', 'textarea')->setHtmlAttributes(['required' => true]),
        ];

        $this->getForm($fields)
            ->setName('permission_form')
            ->setMethod('post')
            ->setActionUrl(route('permission_store'));
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

    public function permission()
    {
        $this->initGrid([
            'title',
            'name',
            'shortDescription',
            Field::init('isActive', 'Active Status')->formatValue(function ($value) {
                return $value == 1 ? "Active" : "Inactive";
            }),
            Field::init('isDeleted', 'Is Deleted')->formatValue(function ($value) {
                return $value == 1 ? "Yes" : "No";
            }),
        ], pagination: 10);
        return view('aimadmin::settings.permission.list');
    }

    public function create()
    {
        $this->initCreate();
        return view('aimadmin::settings.permission.create');
    }

    public function store(PermissionStoreRequest $request)
    {

        $this->permissionService->savePermission($request);
        return redirect('permission')->with('success', 'Permission Created Successfully !');

    }

    public function edit(int $id)
    {
        $singlePermission = $this->permissionService->getSinglePermission($id);
        return view('aimadmin::settings.permission.edit')
            ->with('userApplicationIDs', $this->permissionService->getApplication())
            ->with('permission', $singlePermission->data);

    }

    public function update(PermissionUpdateRequest $request)
    {
        $this->permissionService->updatePermission($request);
        return redirect('permission')->with('success', 'Permission Updated Successfully !');
    }

    public function delete(int $id)
    {
        $this->permissionService->deletePermission($id);
        return redirect('permission')->with('success', 'Permission Deleted Successfully !');
    }

}
