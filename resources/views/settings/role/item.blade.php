<div class="icheck-danger d-inline">
    <input type="checkbox" name="roles[]"
           value="{{ $role['id'] }}"
           @if (in_array($role['id'], $userRole))  checked @endif
           id="role_{{ $role['id'] }}">
    <label for="role_{{ $role['id'] }}">
        {{ $role['title'] }}
    </label>
</div>
