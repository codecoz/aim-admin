import 'bootstrap-datepicker';
import 'bootstrap-datepicker/dist/css/bootstrap-datepicker.css';
import 'admin-lte/plugins/daterangepicker/daterangepicker.css'

$(document).ready(function () {
    // Select all datepicker elements
    $('.datepicker').each(function () {
        // Check if the element is of type 'date'
        if ($(this).attr('type') === 'date') {
            // Change the type attribute to 'text'
            $(this).attr('type', 'text');
        }

        // Initialize the datepicker
        $(this).datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy',
        });
    });
});

