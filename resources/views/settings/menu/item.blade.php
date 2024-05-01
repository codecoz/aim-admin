<div class="icheck-danger d-inline">
    <input type="checkbox" name="menus[]"
           value="{{ $menu['id'] }}"
           @if (in_array($menu['id'], $role->menus??[])) checked @endif
           id="{{ $menu['id'] }}">
    <label for="{{ $menu['id'] }}">
        {{ $menu['title'] }}
    </label>
</div>

<ul>
    @foreach ($menus as $value)
        @if ($menu['id'] == $value['parentID'])
            @include('aimadmin::settings.menu.item', [
                'menu' => $value,
                'menus' => $menus,
                'role' => $role,
            ])
        @endif
    @endforeach
</ul>
