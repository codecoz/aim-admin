@props(['item'])

@inject('sidebarItemHelper', 'CodeCoz\AimAdmin\MenuBuilder\SidebarItemHelper')

@if ($sidebarItemHelper->isHeader($item))

    {{-- Header --}}
    <x-aim-admin::sidebar.header :item="$item"/>

@elseif ($sidebarItemHelper->isSubmenu($item))

    {{-- Treeview menu --}}
    <x-aim-admin::sidebar.treeview :item="$item"/>

@elseif ($sidebarItemHelper->isLink($item))

    {{-- Link --}}
    <x-aim-admin::sidebar.link :item="$item"/>

@endif
