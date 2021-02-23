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