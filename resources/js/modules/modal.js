$(document).delegate(".native-modal", "click", function (e) {
    e.preventDefault();
    const url = $(this).attr('href');
    $("#modal-body-content").load(url, function (response, status, xhr) {
        if (status === "error") {
            const msg = "Sorry but there was an error: ";
            $("#modal-body-content").html(msg + xhr.status + " " + xhr.statusText);
        }
    });
});
