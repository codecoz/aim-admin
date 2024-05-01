<hr class="mb-3" />
<div class="form-group">
    <label for="roles" class="mb-3">Roles:</label>
    <div class="row">
        @foreach ($roles as $roleKey => $role)
            <div class="col-md-4"> <!-- Adjust the column size as needed -->
                @include('aimadmin::settings.role.item', [
                    'key' => $role['id'],
                    'userRole' => [],
                    'role' => $role,
                ])
            </div>
        @endforeach
    </div>
</div>
<hr class="mb-3" />
