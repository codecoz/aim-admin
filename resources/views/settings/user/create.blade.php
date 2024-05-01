<x-aimadmin::layout.main>
    <x-slot:title>
        Create User
    </x-slot:title>
    <x-aimadmin::crud-form title="Create User"/>
    @push('scripts')
        <script type="module">
            $('#GrantType').change(function () {
                if ($(this).val() === 'bl_active_directory') {
                    $('div.form-group:has(input[name="password"]), div.form-group:has(input[name="password_confirmation"])').hide();
                } else {
                    $('div.form-group:has(input[name="password"]), div.form-group:has(input[name="password_confirmation"])').show();
                }
            });
        </script>
    @endpush
</x-aimadmin::layout.main>
