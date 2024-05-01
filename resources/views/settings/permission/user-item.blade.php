<div class="icheck-danger d-inline">
    <input type="checkbox" name="permissions[]"
           value="{{ $permission['id'] }}"
           @if (in_array($permission['id'], $permissions??[])) checked @endif
           id="permission_{{ $permission['id'] }}">
    <label for="permission_{{ $permission['id'] }}">
        {{ $permission['title'] }}
    </label>
</div>
