@props(['item'])

@inject('sidebarItemHelper', 'CodeCoz\AimAdmin\MenuBuilder\SidebarItemHelper')

@if ($sidebarItemHelper->isSubmenu($item))

    {{-- Treeview menu --}}
    <x-aimadmin::sidebar.treeview :item="$item"/>

@elseif ($sidebarItemHelper->isLink($item))

    {{-- Link --}}
    <x-aimadmin::sidebar.link :item="$item"/>

@endif
