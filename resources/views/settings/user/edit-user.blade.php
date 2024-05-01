<x-aimadmin::layout.main>
    <div class="content">
        <div class="card mb-3">
            <div class="card-header ui-sortable-handle">
                <h3 class="card-title">
                    <i class="fa-solid fa-gear"></i>
                    Edit User
                </h3>
                <div class="card-tools">
                    <ul class="nav nav-pills ml-auto">
                        <li class="nav-item">
                            <a href="{{route('user_list')}}"
                               class="btn btn-primary end">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card-body">
                <form name="user_form" action={{ route('user_update') }} method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="id" value="{{ $user->userID }}"/>
                        <input type="hidden" name="old_image" value="{{ $user->profilePicID }}"/>

                        <div class="form-group col-lg-6">
                            <label class="form-label" for="applicationID">Default Application ID</label>
                            <input class="form-control  " id="applicationID" name="applicationID" type="text"
                                   placeholder="Default Application ID" value="{{ $applicationName }}" readonly/>
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="form-label" for="userName">User Name</label>
                            <input class="form-control  " id="userName" name="userName" type="text"
                                   placeholder="Full Name" value="{{ $user->userName }}"/>
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="form-label" for="fullName">Full Name</label>
                            <input class="form-control  " id="fullName" name="fullName" type="text"
                                   value="{{ $user->fullName }}"/>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="form-label" for="emailAddress">Email</label>
                            <input class="form-control  " id="emailAddress" name="emailAddress" type="email"
                                   value="{{ $user->emailAddress }}" readonly/>
                        </div>
                        <div class="form-group col-lg-6">
                            <label class="form-label" for="mobileNumber">Mobile</label>
                            <input class="form-control  " id="mobileNumber" name="mobileNumber" type="text"
                                   value="{{ $user->mobileNumber }}"/>
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="form-label" for="grantType">Authentication Type</label>
                            <select class="form-control" name="grantType" id="grantType" disabled>
                                @foreach ($authList as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $key == $user->grantType ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input class="form-control  " id="GrantType" name="GrantType" type="text"
                               value="{{ $user->grantType }}" hidden/>

                        @if ($user->grantType != 'bl_active_directory')
                            <div class="form-group col-lg-6">
                                <label class="form-label" for="password">Password</label>
                                <p><a href="/change-as-admin/{{ $user->userID }}" class="mt-2"> Change this User
                                        Password</a>
                                </p>
                            </div>
                        @endif

                        <div class="form-group col-lg-6">
                            <label class="form-label" for="image">Upload New Image</label>
                            <input id="image" name="image" class="form-control" type="file" value="">
                        </div>
                    </div>
                    <hr>
                    <div class="form-group mt-3">
                        <div class="icheck-danger d-inline">
                            <input type="checkbox"
                                   id="active_{{ $user->userID }} }}"
                                   name="isActiveUser" value="1" {{ $user->isUserActive ? 'checked' : '' }}>
                            <label for="active_{{ $user->userID }} }}">
                                Active
                            </label>
                        </div>

                    </div>
                    <hr>
                    <div class="form-group mt-3">
                        <label for="roles"><strong>Roles:</strong></label>
                        <div class="row">
                            @foreach ($roles as $roleKey => $role)
                                <div class="col-md-4"> <!-- Adjust the column size as needed -->
                                    @include('aimadmin::settings.role.item', [
                                        'key' => $roleKey,
                                        'userRole' => $userRole,
                                        'role' => $role,
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="permissions">Permissions:</label>
                        <div class="row">
                            @foreach ($permissions as $permissionKey => $permission)
                                <div class="col-md-4"> <!-- Adjust the column size as needed -->
                                    @include('aimadmin::settings.permission.user-item', [
                                        'key' => $permissionKey,
                                        'permissions' => $userPermission,
                                        'permission' => $permission,
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <hr class="mb-2">

                    <div class="flex">
                        <button class="btn btn-primary  float-right" type="submit" value="submit">Submit</button>
                        <a href="{{ route('user_list') }}" class="btn btn-secondary"> Cancel</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-aimadmin::layout.main>
