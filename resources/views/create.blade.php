<x-aim-admin::layout.main>
    <x-slot:title>
        {{ $pageTitle ?? 'Create Item' }}
    </x-slot:title>
    <x-aim-admin::crud-form title="{{ $pageTitle ?? 'Create Item' }}"/>
</x-aim-admin::layout.main>

