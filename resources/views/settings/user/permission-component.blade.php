<div class="form-group">
    <label for="permissions" class="mb-3">Permissions:</label>
    <div class="row">
        @foreach ($permissions as $permissionKey => $permission)
            <div class="col-md-4"> <!-- Adjust the column size as needed -->
                @include('aimadmin::settings.permission.user-item', [
                    'key' => $permission['id'],
                    'permissions' => [],
                    'permission' => $permission,
                ])
            </div>
        @endforeach
    </div>
</div>
<hr class="mb-3"/>
