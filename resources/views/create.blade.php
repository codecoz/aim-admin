<x-aim-admin::layout.main :injectedBottom="$injectedBottom??''" :injectedTop="$injectedTop??''">
    <x-slot:title>
        {{ $pageTitle ?? 'Create Item' }}
    </x-slot:title>
    <x-aim-admin::crud-form title="{{ $pageTitle ?? 'Create Item' }}"/>
</x-aim-admin::layout.main>
