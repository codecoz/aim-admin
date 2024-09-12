<x-aim-admin::layout.main :injectedBottom="$injectedBottom??''" :injectedTop="$injectedTop??''">
    <x-slot:title>
        {{ $pageTitle ?? 'Item Show' }}
    </x-slot:title>
    <x-aim-admin::crud-show title="Item Show"/>
</x-aim-admin::layout.main>

