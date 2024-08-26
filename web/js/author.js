$(document).ready(function() {
    $('body')
        .on('beforeSubmit', '#author-form', function () {
            let form = $(this)
            $.post(form.attr('action'), form.serialize(), function (response) {
                if (response.status === 'success' && response.id.length > 0) {
                    window.location.replace('/redact/author/' + response.id)
                } else {
                    console.log('%cError:' + response.exception.message, 'background: black; color: red;')
                }
            })
            return false;
        })
})

