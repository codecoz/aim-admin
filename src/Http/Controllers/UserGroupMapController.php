<?php

declare(strict_types=1);

namespace CodeCoz\AimAdmin\Http\Controllers;

use CodeCoz\AimAdmin\Contracts\Service\UserGroupMapServiceInterface;
use CodeCoz\AimAdmin\Contracts\Service\UserGroupServiceInterface;
use CodeCoz\AimAdmin\Contracts\Service\UserServiceInterface;
use CodeCoz\AimAdmin\Controller\AbstractAimAdminController;
use CodeCoz\AimAdmin\Field\ButtonField;
use CodeCoz\AimAdmin\Field\ChoiceField;
use CodeCoz\AimAdmin\Field\Field;
use CodeCoz\AimAdmin\Field\InputField;
use CodeCoz\AimAdmin\Http\Requests\UserGroupMapRequest;

class UserGroupMapController extends AbstractAimAdminController
{

    public function __construct(private readonly UserGroupMapServiceInterface $userGroupMapService,
                                private readonly UserGroupServiceInterface    $userGroupService,
                                private readonly UserServiceInterface         $userService,
    )
    {
    }

    public function getRepository()
    {
        return $this->userGroupMapService;
    }

    public function configureActions(): iterable
    {
        return [
            ButtonField::init('new', 'new')->linkToRoute('user_group_map_create')->createAsCrudBoardAction(),
            // ButtonField::init(ButtonField::EDIT)->linkToRoute('user_group_map_edit', function ($row) {
            //     return ['id' => $row['id']];
            // }),
            ButtonField::init(ButtonField::DELETE)->linkToRoute('user_group_map_delete', function ($row) {
                return ['id' => $row['id']];
            }),
            ButtonField::init('submit')->createAsFormSubmitAction(),
            ButtonField::init('cancel')->linkToRoute('user_group_list')->createAsFormAction(),
        ];
    }

    public function configureForm()
    {
        $userGroupData = $this->userGroupService->getAllUserGroup(true);
        $userGroupList = $userGroupData['data'] ?? [];
        $userList = $this->userService->getAllUserIDNameArr();

        $valueAsKey = [];
        foreach ($userGroupList as $value) {
            $valueAsKey[$value['ID']] = $value['name'];
        }
        $fields = [
            ChoiceField::init('group_id', 'Group Name', choiceType: 'select', choiceList: $valueAsKey),
            ChoiceField::init('user_id', 'User', choiceType: 'select', choiceList: $userList)->setCssClass('select2'),
        ];

        $this->getForm($fields)
            ->setName('user_group_map_form')
            ->setMethod('post')
            ->setActionUrl(route('user_group_map_store'));
    }

    public function configureFilter(): void
    {
        $fields = [
            InputField::init('groupID', 'Group ID'),
        ];
        $this->getFilter($fields);
    }

    public function userGroupMap()
    {
        $this->initGrid([
            Field::init('userName', 'User Name'),
         Field::init(   'groupName','Group Name'),
        ], pagination: 10);
        return view('aimadmin::settings.user-group-map.list');
    }

    public function create()
    {
        $userGroupList = $this->userGroupService->getAllUserGroup(true)['data'] ?? [];

        if (empty($userGroupList)) {
            return redirect()->route('user_group_map_list')->with(['error' => 'Please make a User Group First.']);
        }

        $this->initCreate();
        return view('aimadmin::settings.user-group-map.create');
    }

    public function store(UserGroupMapRequest $request)
    {
        $this->userGroupMapService->saveUserGroupMap($request);
        return to_route('user_group_map_list')->with('success', 'User Group Map has been Created Successfully !');
    }

    public function update(UserGroupMapRequest $request)
    {
        $this->userGroupMapService->updateUserGroupMap($request);
        return to_route('user_group_map_list')->with('success', 'User Group Map has been  Updated Successfully !');
    }

    public function edit(int $id)
    {
        $requestedGroup = $this->userGroupMapService->getSingleUserGroupMap($id);
        return view('aimadmin::settings.user-group-map.edit')->with('requestedGroup', $requestedGroup->data);
    }

    public function delete($id)
    {
        $this->userGroupMapService->deleteUserGroupMap((int)$id);
        return to_route('user_group_map_list')->with('success', 'User Group Map has been Deleted Successfully !!!');
    }
}
