<x-aim-admin::layout.main>
    <x-slot:title>
        {{ $pageTitle ?? 'Item List' }}
    </x-slot:title>
    <x-aim-admin::crud-grid title="{{ $pageTitle ?? 'Item List' }}"/>
</x-aim-admin::layout.main>

