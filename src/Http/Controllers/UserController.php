<?php

namespace CodeCoz\AimAdmin\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use CodeCoz\AimAdmin\Contracts\Service\PermissionServiceInterface;
use CodeCoz\AimAdmin\Contracts\Service\RoleServiceInterface;
use CodeCoz\AimAdmin\Contracts\Service\UserServiceInterface;
use CodeCoz\AimAdmin\Controller\AbstractAimAdminController;
use CodeCoz\AimAdmin\Field\Field;
use CodeCoz\AimAdmin\Field\ButtonField;
use CodeCoz\AimAdmin\Field\ChoiceField;
use CodeCoz\AimAdmin\Field\FileField;
use CodeCoz\AimAdmin\Field\InputField;
use CodeCoz\AimAdmin\Field\TextField;
use CodeCoz\AimAdmin\Http\Requests\UpdateUserPasswordRequest;
use CodeCoz\AimAdmin\Http\Requests\UserInfoUpdateRequest;
use CodeCoz\AimAdmin\Http\Requests\UserStoreRequest;
use CodeCoz\AimAdmin\Http\Requests\UserUpdateRequest;
use CodeCoz\AimAdmin\Traits\APITrait;

class UserController extends AbstractAimAdminController
{
    use APITrait;

    public function __construct(
        private readonly UserServiceInterface       $userService,
        private readonly RoleServiceInterface       $roleServiceInterface,
        private readonly PermissionServiceInterface $permissionServiceInterface
    )
    {

    }

    public function getRepository()
    {
        return $this->userService;
    }

    public function configureActions(): iterable
    {
        return [
            ButtonField::init('new', 'new')->linkToRoute('user_create')->createAsCrudBoardAction(),
            ButtonField::init(ButtonField::DETAIL)->linkToRoute('user_detail', function ($row) {
                return ['id' => $row['userID']];
            }),
            ButtonField::init(ButtonField::EDIT)->linkToRoute('user_edit', function ($row) {
                return ['id' => $row['userID']];
            }),
            ButtonField::init(ButtonField::DELETE)->linkToRoute('user_delete', function ($row) {
                return ['id' => $row['userID']];
            }),
            ButtonField::init('submit')->createAsFormSubmitAction(),
            ButtonField::init('cancel')->linkToRoute('user_list')->createAsFormAction(),
        ];
    }


    public function configureForm()
    {
        $applications = $this->userService->getApplication();
        $authList = ['email_password' => 'Email & Password', 'bl_active_directory' => 'BL Active Directory'];

        $fields = [
            InputField::init('fullName')->setHtmlAttributes(['required' => true]),
            InputField::init('userName')->setHtmlAttributes(['required' => true]),
            InputField::init('emailAddress', 'Email', "email")->setHtmlAttributes(['required' => true]),
            InputField::init('mobileNumber')->validate('required|numeric')->setHtmlAttributes(['required' => true]),
            InputField::init('password', 'Password', "password"),
            InputField::init('password_confirmation', 'Confirm Password', "password"),
            FileField::init('image'),
            // TO - Do
            InputField::init('roles')->setComponent('aimadmin::settings.user.role-component')->setLayoutClass('col-md-12')->setHtmlAttributes(['required' => true]),
            InputField::init('permissions')->setComponent('aimadmin::settings.user.permission-component')->setLayoutClass('col-md-12')->setHtmlAttributes(['required' => true]),
        ];

        array_splice($fields, 4, 0, [ChoiceField::init('GrantType', 'Authentication Type', choiceType: 'select', choiceList: $authList)]);

        array_splice($fields, 0, 0, [
            ChoiceField::init(
                'applicationID',
                'Default Application ID',
                choiceType: 'select',
                choiceList: $applications,
                selected: $this->userService->userApplicationID()
            )
        ]);

        $this->getForm($fields)
            ->setName('user_form')
            ->setMethod('post')
            ->setActionUrl(route('user_store'));
    }

    public function configureFilter(): void
    {
        $fields = [
            // TextField::init('userID'),
            TextField::init('userName'),
            TextField::init('fullName'),
            TextField::init('mobileNumber'),
            TextField::init('emailAddress'),
        ];
        $this->getFilter($fields);
    }

    public function user()
    {
        $grid = [
            Field::init('userName', 'User Name'),
            Field::init('fullName', 'Full Name'),
            Field::init('mobileNumber', 'Mobile Number'),
            Field::init('emailAddress', 'Email Address'),
            Field::init('isActive', 'Active Status')->formatValue(function ($value) {
                return $value == 1 ? "Active" : "Inactive";
            }),
        ];
        if (config('aim-admin.core_application_id') == Session::get('applicationID')) {
            $grid[] = Field::init('isDeleted', 'Is Deleted')->formatValue(function ($value) {
                return $value == 1 ? "Yes" : "No";
            });
        }
        $this->initGrid($grid, pagination: 10);
        return view('aimadmin::settings.user.user');
    }


    public function create()
    {
        $this->initCreate();
        return view('aimadmin::settings.user.create');
    }

    public function show($id)
    {
        $singleUser = $this->userService->getSingleUser($id);
        return view('aimadmin::settings.user.single-user')->with('data', $singleUser->data);
    }

    public function store(UserStoreRequest $request)
    {
        $this->userService->saveUser($request);
        return to_route('user_list')->with('success', 'User Created Successfully !');
    }

    public function delete($id)
    {
        $this->userService->deleteUser($id);
        return to_route('user_list')->with('error', "User can not be Deleted !");
    }

    public function edit($id)
    {
        $singleUser = $this->userService->getSingleUser($id);
        $applicationName = $this->userService->getApplicationName($singleUser->data->applicationID);
        $userRole = $this->userService->dataParseFromArr((array)$singleUser->data, 'roles');
        $userPermission = $this->userService->dataParseFromArr((array)$singleUser->data, 'extraPermissions');
        $authList = ['bl_active_directory' => 'BL Active Directory', 'email_password' => 'Email & Password'];
        $permissionFromCurrentApplication = $this->permissionServiceInterface->getAllPermission();
        $permissions = Session::get('applicationID') == config('aim-admin.core_application_id') ? $permissionFromCurrentApplication : $this->getTotalListItem($this->getUserInformation(['extraPermissions', 'rolePermissions']), $permissionFromCurrentApplication);
        return view('aimadmin::settings.user.edit-user')
            ->with('user', $singleUser->data)
            ->with('userRole', $userRole)
            ->with('applicationName', $applicationName)
            ->with('authList', $authList)
            ->with('userPermission', $userPermission)
            ->with('roles', $this->roleServiceInterface->getAllRole())
            ->with('permissions', $permissions);
    }

    public function update(UserUpdateRequest $request)
    {
        $this->userService->updateUser($request);
        return redirect('users')->with('success', 'User Updated Successfully !');
    }

    public function passwordChange()
    {
        $singleUser = $this->userService->getSingleUser(Auth::user()->id);
        if ($singleUser->data->password == null) {
            return redirect('/')->with('warning', 'Please Change Your Windows Password To Reset !');
        }
        return view('aimadmin::settings.user.user-password-reset');
    }

    public function passwordUpdate(UpdateUserPasswordRequest $request)
    {
        if ($request->id) {
            $this->userService->updateUserPassword($request);
            return redirect()->back()->with('success', 'Password has been changed Successfully ! Please Log Out and Log In again.');
        }

        $this->userService->userOldPasswordCheck($request->old_password);
        $this->userService->updateUserPassword($request);
        return redirect()->back()->with('success', 'Password has been changed Successfully ! Please Log Out and Log In again.');
    }

    public function userInfoChange()
    {
        $singleUser = $this->userService->getSingleUser(Auth::id());
        return view('aimadmin::settings.user.user-info-change')
            ->with('user', $singleUser->data);
    }

    public function userInfoUpdate(UserInfoUpdateRequest $request)
    {
        $singleUser = $this->userService->getSingleUser($request->id);
        $userRole = $this->userService->dataParseFromArr((array)$singleUser->data, 'roles');
        $userPermission = $this->userService->dataParseFromArr((array)$singleUser->data, 'permissions');
        $extraPermissions = $this->userService->dataParseFromArr((array)$singleUser->data, 'extraPermissions');
        $rolePermission = $this->userService->dataParseFromArr((array)$singleUser->data, 'rolePermissions');
        $userPermission = array_merge($userPermission, $extraPermissions, $rolePermission);
        $request->request->add(['roles' => $userRole]);
        $request->request->add(['permissions' => $userPermission]);
        $this->userService->updateUser($request);
        return redirect()->back()->with('success', 'Successfully updated !');
    }

    public function changeAsAdmin($id)
    {
        return view('aimadmin::settings.user.change-user-password-as-admin', compact('id'));
    }
}
