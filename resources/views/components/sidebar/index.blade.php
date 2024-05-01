@php
    use CodeCoz\AimAdmin\MenuBuilder\AimAdminMenu;
    $applicationName = env('APP_NAME', 'Native BL');
    $menus = app(AimAdminMenu::class)->menu('sidebar');
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    {{-- Sidebar brand logo --}}
    <a href="{{URL('/')}}" class="brand-link {{config('aim-admin.layout_class.brand', '')}}">
        <img src="{{asset('img/blx100x100.png')}}" alt="Native BL" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{$applicationName}}</span>
    </a>

    {{-- Sidebar menu --}}
    <div class="sidebar">

        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent {{config('aim-admin.layout_class.sidebar', '')}}"
                data-widget="treeview" role="menu"
                data-accordion="false">
                {{-- Configured sidebar links --}}
                @foreach($menus as $item)
                    <x-aimadmin::sidebar.item :item="$item"/>
                @endforeach
            </ul>
        </nav>
    </div>

</aside>

