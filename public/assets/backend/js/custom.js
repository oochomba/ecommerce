function confirmDelete(elem) {
    var _token = $(elem).attr("data-token");
    var formId = $(elem).attr("data-formId");
    var href = $(elem).attr("data-href");
    var id = $(elem).attr("data-href");

    var result = confirm("You are about to delete this record. Are you sure?");
    if (result) {
        $.ajax({
            type: "post",
            url: href,
            dataType: "json",
            data: {
                _token: _token,
            },
            beforeSend: function () {},
            success: function (data) {
                if (data.status == false) {
                    alert(data.message);
                } else {
                    window.location.href = data.redirect;
                }
            },
        });
    }
}




