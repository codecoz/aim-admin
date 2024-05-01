<x-aimadmin::layout.main>
    <x-slot:title>
        {{ $pageTitle ?? 'Edit Item' }}
    </x-slot:title>
    <x-aimadmin::crud-form title="{{ $pageTitle ?? 'Edit Item' }}"/>
</x-aimadmin::layout.main>

