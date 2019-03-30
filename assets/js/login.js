$(function()
{
    alertify.set('notifier','position', 'top-center');

    $("#loginBtn").click(function () {
        var userName = $("#name").val();
        var password = $("#password").val();
        $.controlValues(userName,password);
    })

    $.ajaxAction("#loginBtn");
});

$.controlValues = function (username,password) {

    username = $.trim(username);
    password = $.trim(password);

    if (username == "" || password == "")
    {
        return -1;
    }else{
        
        $.ajax({
            url:"/ajax/loginajax/",
            type:"post",
            data:{username:username,password:password},
            success:function (data) {
                var myData =  JSON.parse(data);
                if(myData.val == 1){
                    alertify.success(myData.msg);
                    $.Redirect(myData.urlDirect);
                }else{
                    alertify.error(myData.msg);
                }
            }
        })
    }
}

$.Redirect = function (urlDirect) {
    setTimeout(function() {
        window.location.replace(urlDirect);
    }, 2000);
}


$.ajaxAction = function(elementId){
    
    $(document).ajaxSend(function() {
        $(elementId).prop("disabled",true);
    });

    $(document).ajaxComplete(function() {
        $(elementId).prop("disabled",false);
    });

}
