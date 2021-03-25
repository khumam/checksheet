function showToast(message, name) {
    var toastHTML = `<div class="toast fade hide" data-delay="3000">
            <div class="toast-header">
                <i class="anticon anticon-info-circle text-primary m-r-5"></i>
                <strong class="mr-auto">${name}</strong>
                <button type="button" class="ml-2 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>`

    $('#notification').append(toastHTML)
    $('#notification .toast').toast('show');
    setTimeout(function() {
        $('#notification .toast:first-child').remove();
    }, 3000);
}

function sweatAlert(icon, message) {
    Swal.fire({
        title: message,
        icon: icon,
    }).then((Confirm) => {
        location.reload()
    });
}

$(document).on('click', '.deleteButton', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data tidak dapat dikembalikan!",
        type: "warning",
        showCancelButton: true,
        dangerMode: true,
        cancelButtonClass: '#DD6B55',
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Hapus!',
    }).then(Confirm => {
        if (Confirm.value) {
            form.submit();
        }
    })
})