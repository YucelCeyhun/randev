$(function () {
    alertify.set('notifier', 'position', 'top-center');
    $.ajaxAction("#createBtn");
    $("#createBtn").click(function () {
        var username = $("#name");
        var password = $("#password");
        var passwordRepeat = $("#password-repeat");
        var tel = $("#tel");
        var email = $("#email");
        var companies = $("#companies");
        var engineers = $("#engineers");
        $.controlValues(username, password, passwordRepeat, tel, email, companies, engineers);
    })
    $.InputRemoveClass();

});

$.controlValues = function (username, password, passwordRepeat, tel, email, companies, engineers) {
    username.val($.trim(username.val()));
    password.val($.trim(password.val()));
    passwordRepeat.val($.trim(passwordRepeat.val()));
    tel.val($.trim(tel.val()));
    email.val($.trim(email.val()));
    var formInput = Array(username, password, passwordRepeat, tel, email);
    if ($.InputEmtypControl(formInput)) {
        $.ajax({
            url: "/ajax/UserCreateAjax/",
            type: "post",
            data: {
                username: username.val(), password: password.val(), passwordRepeat: passwordRepeat.val(),
                tel: tel.val(), email: email.val(), companies: companies.val(), engineers: engineers.val()
            },
            success: function (data) {
                var myData = JSON.parse(data);
                if (myData.val == 1) {
                    $.DisElement("#createBtn");
                    alertify.success(myData.msg);
                    $.Redirect(myData.urlDirect)
                } else {
                    alertify.error(myData.msg);
                }
            }
        })

    }

}
