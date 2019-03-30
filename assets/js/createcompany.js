alertify.set('notifier', 'position', 'top-center');
$(function () {
    $.ajaxAction("#createBtn");
    $("#createBtn").click(function () {
        var name = $("#name");
        var address = $("#address");
        var tel = $("#tel");
        var email = $("#email");
        var user = $("#users");
        $.createEngineer(name, address, tel, email, user);
    })
    $.InputRemoveClass();

})

$.createEngineer = function (name, address, tel, email, user) {
    name.val($.trim(name.val()));
    address.val($.trim(address.val()));
    tel.val($.trim(tel.val()));
    email.val($.trim(email.val()));
    user.val($.trim(user.val()));

    var formInput = Array(name, address, tel);
    if ($.InputEmtypControl(formInput)) {
        $.ajax({
            url: "/ajax/companycreateajax/",
            type: "post",
            data: {
                name: name.val(), address: address.val(), tel: tel.val(), email: email.val(), user: user.val()
            },
            success: function (data) {
                var myData = JSON.parse(data);
                if (myData.val == 1) {
                    alertify.success(myData.msg);
                    $.Redirect(myData.urlDirect);
                    $.DisElement("#createBtn");
                } else {
                    alertify.error(myData.msg);
                }
            }
        })
    }
}