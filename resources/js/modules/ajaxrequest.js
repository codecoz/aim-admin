$('.btn-submit-action').on('click', function (e) {
    $("#myForm").submit();
});

window.loadModal = function (url) {
    $("#body-content").load(url);
}

window.fadeOutAndClear = function (elementId, timeout = 2000) {
    setTimeout(() => {
        $(`#${elementId}`).fadeOut('slow', function () {
            $(this).html('');
            $(this).show(); // Ensure it’s not permanently hidden if you want to reuse it.
        });
    }, timeout);
};

window.ajaxRequest = function (url, data = {}, successCallback, errorCallback, completeCallback, method = 'POST') {
    swal.fire({
        html: 'Please wait ... ',
        allowOutsideClick: false,
        didOpen: () => {
            swal.showLoading()
        },
    });
    let settings = {
        url: url,
        type: method,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
            console.log(response);
            if (response.data && response.alert) {
                $("#alert").html(response.alert);
                if (response.fade_out) {
                    window.fadeOutAndClear('alert', 3000);
                }
            }

            if (response.data && response.redirect) {
                // Redirect after a delay (2 or 3 seconds)
                setTimeout(function () {
                    // Use window.location.href for redirection
                    window.location.href = response.redirect;
                }, 1000); // Delay in milliseconds (2000ms = 2s, change to 3000 for 3s)
            }
        },
        error: function (error) {
            let response;
            if (error && error.responseJSON) {
                response = error.responseJSON;
                if (response.alert) {
                    $("#alert").html(response.alert);
                }
            } else {
                console.error('An error occurred:', error);
            }
            if (response.fade_out) {
                window.fadeOutAndClear('alert', 2000);
            }
            // Call the errorCallback after handling the error
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(error);
            }
        },
        complete: function (data) {
            console.log('Data', data);
            if (data.data && data.data.scroll_to_top) {
                $('html, body').scrollTop(0);
            }
            swal.close();
            if (completeCallback && typeof completeCallback === 'function') {
                completeCallback();
            }
        }
    };

    if (method !== 'GET' && data instanceof FormData) {
        settings.processData = false; // don't process the data
        settings.contentType = false; // set content type to false as jQuery will tell the server it's a query string request
    }

    $.ajax(settings);
};

window.ajaxPost = function (url, data, successCallback, errorCallback, completeCallback) {
    ajaxRequest(url, data, successCallback, errorCallback, completeCallback);
};

window.ajaxGet = function (url, data, successCallback, errorCallback, completeCallback) {
    // For a GET request, we need to append data to the URL as query parameters
    const queryParams = $.param(data); // Use jQuery's $.param to convert data object to query string
    const fullUrl = url + (queryParams ? '?' + queryParams : '');

    // Call the ajaxRequest function with the full URL including query parameters
    // Since GET requests don't have a body, we pass an empty object ({}) for the data parameter
    ajaxRequest(fullUrl, {}, successCallback, errorCallback, completeCallback, 'GET');
};

window.ajaxPut = function (url, data, successCallback, errorCallback, completeCallback) {
    data.append('_method', 'put'); // Add the _method field with value 'PATCH'
    ajaxRequest(url, data, successCallback, errorCallback, completeCallback);
};

window.ajaxPatch = function (url, data, successCallback, errorCallback, completeCallback) {
    data.append('_method', 'patch'); // Add the _method field with value 'PATCH'
    ajaxRequest(url, data, successCallback, errorCallback, completeCallback);
};

window.executeAjaxCall = (method, url, data, successCallback, errorCallback, completeCallback) => {
    // Determine the AJAX function to use based on the method
    let ajaxFunction;
    switch (method.toLowerCase()) {
        case 'get':
            ajaxFunction = window.ajaxGet;
            break;
        case 'put':
            ajaxFunction = window.ajaxPut;
            break;
        case 'patch':
            ajaxFunction = window.ajaxPatch;
            break;
        // Add more cases as needed
        default:
            ajaxFunction = window.ajaxPost;
    }

    // Call the selected AJAX function
    ajaxFunction(url, data, successCallback, errorCallback, completeCallback);
}


window.resetForm = function () {

// Reset text, email, password fields
    $('#ajax-form input[type="text"], #ajax-form input[type="email"], #ajax-form input[type="password"], #ajax-form textarea').val('');

// Reset radio buttons and checkboxes
    $('#ajax-form input[type="radio"], #ajax-form input[type="checkbox"]').prop('checked', false);

// Reset select dropdowns
    $('#ajax-form select').prop('selectedIndex', 0);

}

$(document).delegate(".ajax-submit-button", "click", function (event) {
    event.preventDefault();
    $("#alert").html("");
    const btn = $(this);

    $('[tinymce-id]').each(function () {
        const tmcIdValue = $(this).attr('tinymce-id');
        tinymceEditorsMap[tmcIdValue].triggerSave();
    });

    const form = btn.closest('form'); // Using .closest() to find the parent form
    const formData = new FormData(form[0]);

    const requestMethod = form.attr('method'); // Using attr method

    executeAjaxCall(requestMethod, $(form).attr('action'), formData, function (data) {
        console.log('Received data:', data);
        // resetForm()
    }, function (error) {
        console.error('An unexpected error occurred:', error);
    }, function () {
        console.log('Request completed');
    });
});
