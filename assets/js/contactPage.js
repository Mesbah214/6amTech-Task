(function ($) {
    // Delete contact from database
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

    // Insert or update contact in database
    $(".submit-contact").on("click", function (e) {
        e.preventDefault();
        form = $(".contact-form");

        let data = form.serialize();
        let nonce = $("#_wpnonce");
        let id = $("[name='id']").val() || 0;

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
                    if (!id) form[0].reset();
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
