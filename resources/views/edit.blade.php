<x-aim-admin::layout.main :injectedBottom="$injectedBottom??''" :injectedTop="$injectedTop??''">
    <x-slot:title>
        {{ $pageTitle ?? 'Edit Item' }}
    </x-slot:title>
    <x-aim-admin::crud-form title="{{ $pageTitle ?? 'Edit Item' }}"/>
</x-aim-admin::layout.main>

