<div class="icheck-danger d-inline">
    <input type="checkbox" name="permissions[]"
           value="{{ $key }}"
           @if (in_array($key, $role->permissions??[])) checked @endif
           id="{{ $key }}">
    <label for="{{ $key }}">
        {{ $permission }}
    </label>
</div>
