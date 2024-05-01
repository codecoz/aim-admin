@foreach ($children as $childKey => $childSubMenu)
    @php
        $active = in_array($segment, getChildrenKeys($childSubMenu)) || $childKey == $segment
    @endphp
    @if (empty($childSubMenu['children']))
        <a class="sidebar-link {{$active?'active-menu':''}}" href="{{ '/' . $childKey }}">
            <i data-feather="{{ ucfirst(str_replace('-', ' ', $childKey)) }}"></i>
            <span class="align-middle">{{ $childSubMenu['title'] }}</span>
        </a>
    @else
        <a class="sidebar-link collapsed {{$active?'active-menu':''}}" data-bs-target="#{{ Str::slug($childKey) }}"
           data-bs-toggle="collapse">
            <i data-feather="{{ ucfirst(str_replace('-', ' ', $key)) }}"></i>
            <span class="align-middle">{{ $childSubMenu['title'] }}</span>
        </a>
        <li class="sidebar-item">
            <ul class="sidebar-dropdown collapse bl-list-un-styled" id="{{ Str::slug($childKey) }}">
                @include('aimadmin::menu.render-sub-menu', [
                        'segment' => $segment,
                        'children' => $childSubMenu['children'],
                    ])
            </ul>
        </li>
    @endif
@endforeach
