@props(['item'])

@inject('sidebarItemHelper', 'CodeCoz\AimAdmin\MenuBuilder\SidebarItemHelper')

@if ($sidebarItemHelper->isSubmenu($item))

    {{-- Treeview menu --}}
    <x-aim-admin::sidebar.treeview :item="$item"/>

@elseif ($sidebarItemHelper->isLink($item))

    {{-- Link --}}
    <x-aim-admin::sidebar.link :item="$item"/>

@endif
