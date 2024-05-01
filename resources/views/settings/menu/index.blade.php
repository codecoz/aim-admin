@php
    $segment = request()->segment(1)??'null';
@endphp

<nav class="sidebar js-sidebar" id="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="/">
            <span class="align-middle">{{env('APP_NAME')}}</span>
        </a>
        @if (session()->has('menus'))
            <ul class="sidebar-nav">
                @foreach (session()->get('menus') as $key => $subMenu)

                    @php
                        $active = in_array($segment, getChildrenKeys($subMenu))
                    @endphp

                    <li class="sidebar-item">
                        @if (empty($subMenu['children']))
                            <a class="sidebar-link {{$active || $key == $segment?'active-menu':''}}"
                               href="{{ '/' . $key }}">
                                <i data-feather="{{ ucfirst(str_replace('-', ' ', $key)) }}"></i>
                                <span class="align-middle">{{ $subMenu['title'] }}</span>
                            </a>
                        @else
                            <a class="sidebar-link collapsed" data-bs-target="#{{ Str::slug($key) }}"
                               data-bs-toggle="collapse">
                                <i data-feather="{{ ucfirst(str_replace('-', ' ', $key)) }}"></i>
                                <span class="align-middle">{{ $subMenu['title'] }}</span>
                            </a>
                            <ul class="sidebar-dropdown collapse list-unstyled {{ $active ? 'show' : '' }}"
                                id="{{ Str::slug($key) }}">
                                @include('aimadmin::menu.render-sub-menu', [
                                    'segment' => $segment,
                                    'children' => $subMenu['children'],
                                ])
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</nav>
