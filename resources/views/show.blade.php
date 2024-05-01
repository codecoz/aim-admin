<x-aimadmin::layout.main>
    <x-slot:title>
        {{ $pageTitle ?? 'Item Show' }}
    </x-slot:title>
    <x-aimadmin::crud-show title="Item Show"/>
</x-aimadmin::layout.main>

