(function ($) {
    $("table.wp-list-table.contacts").on("click", "a.submitdelete", function (e) {
        e.preventDefault();

        if (!confirm(_6amtech_contact.confirm)) {
            return;
        }

        let self = $(this),
            id = self.data("id");

        $.ajax({
            url: _6amtech_contact.ajax_url,
            type: "POST",
            data: {
                action: "delete_contact",
                id: id,
                _wpnonce: _6amtech_contact.nonce,
            },
            success: function (response) {
                if (response.success) {
                    self.closest("tr")
                        .css("background-color", "#fdd")
                        .hide(400, function () {
                            $(this).remove();
                        });
                    toastr.success(response.data.message);
                } else {
                    toastr.error(response.data.message || _6amtech_contact.error);
                }
            },
            error: function () {
                toastr.error(_6amtech_contact.error);
            },
        });
    });

    $("#add_contact").on("click", function (e) {
        e.preventDefault();
        form = $("#add_contact_form");

        let data = form.serialize();
        let nonce = $("#_wpnonce");
        console.log(nonce.val());

        $.ajax({
            url: _6amtech_contact.ajax_url,
            type: "POST",
            data: {
                action: "add_contact",
                data: data,
                _wpnonce: nonce.val(),
            },
            success: function (response) {
                if (response.success) {
                    toastr.success(response.data.message);
                    form[0].reset();
                } else {
                    toastr.error(response.data.message || _6amtech_contact.error);
                }
            },
            error: function () {
                toastr.error(_6amtech_contact.error);
            },
        });
    });
})(jQuery);
