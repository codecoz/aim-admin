import Swal from 'sweetalert2'

window.swal = Swal;

// var popupConfirmList = [].slice.call(document.querySelectorAll('[data-bl-popup="confirm"]'))
// var popupList = popupConfirmList.map(function (popupTriggerEl) {
//   return new bootstrap.Tooltip(popupTriggerEl)
// })

window.gridDeleteConfirm = function(el)
{
    Swal.fire({
        icon: 'warning',
        text: 'Do you want to delete this item?',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        confirmButtonColor: '#e3342f',
    }).then((result) => {
         if(result.isConfirmed){
           el.submit();
         }
    });
   return false;
}

window.toastFire = (type, msg) => {
    Swal.fire({
        toast: true,
        timer: 3000,
        showCloseButton: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        text: msg,
        icon: type,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
}

window.toastFireWithAction = (type, response) => {
    Swal.fire({
        toast: true,
        timer: 3000,
        showCloseButton: true,
        position: 'top-end',
        showConfirmButton: false,
        timerProgressBar: true,
        text: response.message,
        icon: type,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    if (response.hasOwnProperty('redirect')) {
        window.location.replace(response.redirect);
    }
}
