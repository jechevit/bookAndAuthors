$(document).ready(function() {
    $('body')
        .on('beforeSubmit', '#author-form', function () {
            let form = $(this)
            $.post(form.attr('action'), form.serialize(), function (response) {
                if (response.status === 'success') {
                    window.location.reload()
                } else {
                    console.log('%cError:' + response.exception.message, 'background: black; color: red;')
                }
            })
            return false;
        })
})

