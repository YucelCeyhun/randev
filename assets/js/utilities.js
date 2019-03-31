$.Redirect = function (urlDirect) {
    setTimeout(function () {
        window.location.replace(urlDirect);
    }, 2000);
}

$.Reload = function (urlDirect) {
    setTimeout(function () {
        window.location.reload();
    }, 2000);
}

$.InputEmtypControl = function (inputArray) {
    var returnVal = true;
    inputArray.some(function (val) {
        if (val.val() == "") {
            alertify.error("Gerekli alanları doldurunuz.");
            val.addClass("input-error");
            returnVal = false;
            return true;
        }
    })
    return returnVal;
}

$.InputRemoveClass = function () {
    $("input").focus(function () {
        if ($(this).hasClass("input-error")) {
            $(this).removeClass("input-error");
        }
    })
}

$.AsyncAjax = function (url, myData) {
    var returnedVal;
    $.ajax({
        async: false,
        url: url,
        type: "post",
        data: myData,
        success: function (data) {
            var myData = JSON.parse(data);
            if (myData.val == 1) {
                returnedVal = true;
            } else {
                alertify.error(myData.msg);
                returnedVal = false;
            }
        },
        error: function () {
            returnedVal = "error";
        }

    })
    return returnedVal;
}


$.ajaxAction = function(elementId){
    
    $(document).ajaxSend(function() {
        $(elementId).prop("disabled",true);
    });

    $(document).ajaxComplete(function() {
        $(elementId).prop("disabled",false);
    });

}

$.DisElement = function(element){
    $(document).ajaxSend(function() {
       $(element).prop("disabled",true);
   });
 }

