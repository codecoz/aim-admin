<label class="menu-item">
    <input type="checkbox" name="menus[]" value="{{ $menu['id'] }}" data-parent-id="{{ $menu['id'] }}"
           @if (in_array($menu['id'], $role->menus??[])) checked @endif>
    {{ $menu['title'] }}
</label>

<ul>
    @foreach ($menus as $value)
        @if ($menu['id'] == $value['parentID'])
            @include('aimadmin::settings.user.menu-item', [
                'menu' => $value,
                'menus' => $menus,
                'role' => $role,
            ])
        @endif
    @endforeach
</ul>
