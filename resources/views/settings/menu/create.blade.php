<x-aimadmin::layout.main>
    <x-slot:title>
      Create Menu
    </x-slot:title>
    <x-aimadmin::crud-form title="Create Menu" />
    @push('scripts')
        <script type="module">
            $(document).ready(function() {
                // Function to format icons in the dropdown
                function formatIcon(option) {
                    // Check if the option has a value, to avoid errors on placeholder items
                    if (!option.id) return option.text; // return the text for placeholder items

                    // Create and return the formatted option with icon
                    return $(`<span><i class="fa fa-${option.element.value}"></i> ${option.text}</span>`);
                }
                // Initialize Select2 with icon formatting
                $('.icons_select2').select2({
                    width: '100%', // Ensures the dropdown takes the full width of its container
                    templateSelection: formatIcon, // Use the formatIcon function for selected items
                    templateResult: formatIcon // Use the same function for dropdown items
                });
            });
        </script>

    @endpush
</x-aimadmin::layout.main>
