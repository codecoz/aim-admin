<?php declare(strict_types=1);

namespace CodeCoz\AimAdmin\Http\Controllers;

use CodeCoz\AimAdmin\Contracts\Service\UserGroupServiceInterface;
use CodeCoz\AimAdmin\Controller\AbstractAimAdminController;
use CodeCoz\AimAdmin\Field\ButtonField;
use CodeCoz\AimAdmin\Field\InputField;
use CodeCoz\AimAdmin\Field\TextField;
use CodeCoz\AimAdmin\Http\Requests\UserGroupCreateRequest;

class UserGroupController extends AbstractAimAdminController
{

    public function __construct(private readonly UserGroupServiceInterface $userGroupService)
    {

    }

    public function getRepository()
    {
        return $this->userGroupService;
    }

    public function configureActions(): iterable
    {
        return [
            ButtonField::init('new', 'new')->linkToRoute('user_group_create')->createAsCrudBoardAction(),
            ButtonField::init(ButtonField::EDIT)->linkToRoute('user_group_edit', function ($row) {
                return ['id' => $row['id']];
            }),
            ButtonField::init(ButtonField::DELETE)->linkToRoute('user_group_delete', function ($row) {
                return ['id' => $row['id']];
            }),
            ButtonField::init('submit')->createAsFormSubmitAction(),
            ButtonField::init('cancel')->linkToRoute('user_group_list')->createAsFormAction(),
        ];
    }

    public function configureForm()
    {

        $fields = [
            InputField::init('name')->setHtmlAttributes(['required' => true]),
        ];

        $this->getForm($fields)
            ->setName('user_group_form')
            ->setMethod('post')
            ->setActionUrl(route('user_group_store'));
    }

    public function configureFilter(): void
    {
        $fields = [
            TextField::init('name'),
        ];
        $this->getFilter($fields);
    }

    public function userGroup()
    {
        $this->initGrid([
            'name',
        ], pagination: 10);
        return view('aimadmin::settings.user-group.list');
    }

    public function create()
    {
        $this->initCreate();
        return view('aimadmin::settings.user-group.create');
    }

    public function store(UserGroupCreateRequest $request)
    {
        $this->userGroupService->saveUserGroup($request);
        return to_route('user_group_list')->with('success', 'User Group has been Created Successfully !');
    }

    public function update(UserGroupCreateRequest $request)
    {
        $this->userGroupService->updateUserGroup($request);
        return to_route('user_group_list')->with('success', 'User Group has been  Updated Successfully !');
    }

    public function edit(int $id)
    {
        $requestedGroup = $this->userGroupService->getSingleUserGroup($id);
        return view('aimadmin::settings.user-group.edit')->with('requestedGroup', $requestedGroup->data);
    }

    public function delete($id)
    {
        $this->userGroupService->deleteUserGroup((int)$id);
        return to_route('user_group_list')->with('success', 'User Group has been Deleted Successfully !!!');
    }
}
