$(function () {
    $("#createBtn").click(function () {
        var name = $("#name");
        var tel = $("#tel");
        var email = $("#email");
        var user = $("#users");
        var mapAddress = $("#map-address");
        var mapLatLng = $("#map-address-latlng");
        $.createEngineer(name, tel, email, user, mapAddress, mapLatLng);
    })
    $.InputRemoveClass();
})

$.createEngineer = function (name, tel, email, user, mapAddress, mapLatLng) {
    name.val($.trim(name.val()));
    tel.val($.trim(tel.val()));
    email.val($.trim(email.val()));
    user.val($.trim(user.val()));
    mapAddress.val($.trim(mapAddress.val()));
    mapLatLng.val($.trim(mapLatLng.val()));
    var formInput = Array(name, tel, email, mapAddress, mapAddress, mapLatLng);
    if ($.InputEmtypControl(formInput)) {

        $.ajax({
            url: "/ajax/engineercreateajax/",
            type: "post",
            data: {
                name: name.val(), tel: tel.val(), email: email.val(), user: user.val(), mapAddress: mapAddress.val(), mapLatLng: mapLatLng.val()
            },
            success: function (data) {
                var myData = JSON.parse(data);
                if (myData.val == 1) {
                    $.DisElement("#createBtn");
                    alertify.success(myData.msg);
                    $.Redirect(myData.urlDirect);
                } else {
                    alertify.error(myData.msg);
                }
            }
        })
    }
}