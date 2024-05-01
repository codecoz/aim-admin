document.addEventListener('DOMContentLoaded', (event) => {
    // Get all list items
    const listItems = document.querySelectorAll('.list-group-item');

    // Add click event listener to each list item
    listItems.forEach(item => {
        item.addEventListener('click', (e) => {
            // Stop event propagation
            e.stopPropagation();
        });
    });

    // Code to handle clicking outside the dropdown to close it
    window.addEventListener('click', (e) => {
        const dropdownMenu = document.getElementById('notification-list');
        if (!dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.remove('show');
        }
    });
});

$(document).ready(function () {
    $(".notification-button").click(function (event) {
        event.preventDefault(); // Prevent the default action of the button
        const btn = $(this);
        btn.buttonLoader('start');
        const actionUrl = $(this).data('action');
        ajaxGet(actionUrl, [], function (data) {
            console.log('Received data:', data);
            btn.closest('.list-group-item').hide();

            const notificationDropdown = $('#notification-dropdown-count');
            const notificationIndicator = $('#notification-indicator-count');

            const dropdownCount = parseInt(notificationDropdown.text(), 10);
            notificationDropdown.text(dropdownCount > 0 ? dropdownCount - 1 : 0);

            const indicatorCount = parseInt(notificationIndicator.text(), 10);
            notificationIndicator.text(indicatorCount > 0 ? indicatorCount - 1 : 0);

            // resetForm()
        }, function (error) {
            btn.buttonLoader('stop');
            console.error('An unexpected error occurred:', error);
        }, function () {
            btn.buttonLoader('stop');
            console.log('Request completed');
        });
    });
    $(".notification-go").click(function (event) {
        event.preventDefault(); // Prevent the default action of the button
        const btn = $(this);
        btn.buttonLoader('start');
        window.location = $(this).data('action')
    });
});
