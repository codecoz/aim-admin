<label class="menu-item">
    <input type="checkbox" name="menus[]" value="{{ $menu['id'] }}" data-parent-id="{{ $menu['id'] }}"
    >
    {{ $menu['title'] }}
</label>

<ul>
    @foreach ($menus as $value)
        @if ($menu['id'] == $value['parentID'])
            @include('aimadmin::settings.user.menu-item-create', [
                'menu' => $value,
                'menus' => $menus,
            ])
        @endif
    @endforeach
</ul>
