lightbox.option({
    'resizeDuration': 200,
    'disableScrolling': true
})

$("#signIn").submit(function (e) {
    e.preventDefault();
    $('.formError.userLogin').remove();
    $.ajax({
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                "content"
            )
        },
        url: baseURL + "/api/login",
        data: $("#signIn").serializeArray(),
        success: function (res) {
            window.location.reload();
        },
        error: function (err) {
            if (err.status == '401') {
                let errMsg = document.createElement('div');
                errMsg.className = "formError userLogin";
                errMsg.innerHTML = 'Invalid email/password combination';
                return document.querySelector(`.buttonRow`).after(errMsg);
            }

            let errors = err.responseJSON.errors;
            Object.keys(errors).forEach(key => {
                console.log(document.querySelector(`input[name=${key}]`));
                let errMsg = document.createElement('div');
                errMsg.className = "formError userLogin";
                errMsg.innerHTML = errors[key];
                document.querySelector(`input[name=${key}]`).after(errMsg);
            });
        }
    });
});
