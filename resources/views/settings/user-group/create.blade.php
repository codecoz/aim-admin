<x-aimadmin::layout.main>
    <x-slot:title>
        {{ $pageTitle ?? 'Create User Group' }}
    </x-slot:title>
    <x-aimadmin::crud-form title="{{ $pageTitle ?? 'Create User Group' }}"/>
</x-aimadmin::layout.main>

