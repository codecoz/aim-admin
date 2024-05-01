<div class="form-group">
    <label for="menus">Menu:</label>
    @foreach ($menus as $menu)
        @if ($menu['parentID'] == 0)
            <div class="menu-container">
                <ul>
                    @include('aimadmin::settings.user.menu-item-create', [
                        'menu' => $menu,
                        'menus' => $menus
                    ])
                </ul>
            </div>
        @endif
    @endforeach
</div>
