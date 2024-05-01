<x-aimadmin::layout.main>
    <x-slot:title>
        {{ $pageTitle ?? 'Item List' }}
    </x-slot:title>
    <x-aimadmin::crud-grid title="{{ $pageTitle ?? 'Item List' }}"/>
</x-aimadmin::layout.main>

