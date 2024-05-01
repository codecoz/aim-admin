<x-aimadmin::layout.main>
    <x-slot:title>
        {{ $pageTitle ?? 'Create Item' }}
    </x-slot:title>
    <x-aimadmin::crud-form title="{{ $pageTitle ?? 'Create Item' }}"/>
</x-aimadmin::layout.main>

