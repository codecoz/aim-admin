<x-aimadmin::layout.main>
    <x-slot:title>
        {{ $pageTitle ?? 'Create User Group Map' }}
    </x-slot:title>
    <x-aimadmin::crud-form title="{{ $pageTitle ?? 'Create User Group Map' }}"/>
    @push('scripts')
        <script type="module">
            $('.select2').select2({theme: 'bootstrap4', width: '100%'})

        </script>
    @endpush
</x-aimadmin::layout.main>

