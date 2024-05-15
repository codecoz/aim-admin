<x-aim-admin::layout.main>
    <x-slot:title>
        {{ $pageTitle ?? 'Edit Item' }}
    </x-slot:title>
    <x-aim-admin::crud-form title="{{ $pageTitle ?? 'Edit Item' }}"/>
</x-aim-admin::layout.main>

