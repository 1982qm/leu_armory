
function show_error(msg) {
    $("#messages-modal-text").text(msg);
    $("#messages-modal-content").removeClass("infoMsg");
    $("#messages-modal-content").addClass("errorMsg");
    show_modal("messages-modal");
    setTimeout(function () {
        hide_modal("messages-modal");
    }, 1000);
}

function show_info(msg) {
    $("#messages-modal-text").text(msg);
    $("#messages-modal-content").removeClass("errorMsg");
    $("#messages-modal-content").addClass("infoMsg");
    show_modal("messages-modal");
    setTimeout(function () {
        hide_modal("messages-modal");
    }, 1000);
}

function show_modal(modalName, enterButton) {
    $("#" + modalName).show();
    if (enterButton != null) {
        $("#" + modalName).keypress(function (e) {
            if (e.which == 13) {
                $("#" + enterButton).click();
            }
        });
    };
};

function show_confirmation_modal(msg, callback) {
    $('#modal-confirm-btn-yes').on("click", function () { hide_modal("confirm-modal"); callback() });
    $('#modal-confirm-btn-no').on("click", function () { hide_modal("confirm-modal") });
    $("#confirm-modal-text").text(msg);
    $('#confirm-modal').show();
    $('#confirm-modal').keypress(function (e) {
        if (e.which == 13) {
            $('#modal-confirm-btn-no').click();
        }
    });
};

function hide_modal(modalName) {
    $("#" + modalName).hide();
};