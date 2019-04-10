$(function(){
    $("#uploadBtn").click($.uploadExcel);

})

$.uploadExcel = function(){
  var formdata = new FormData($('form')[0]);
  $("#excelprogress").width(0 +'%');
  $("#autocreate-progress > span").html(0 +'%');
    $.ajax({
        url: "/ajax/UploadExcelAjax/",
        type: "post",
        data:formdata,
        xhr: function()
        {
        var appXhr = $.ajaxSettings.xhr();
        if(appXhr.upload)
        {
            appXhr.upload.addEventListener('progress',trackUploadProgress, false);
        }
        return appXhr;
        },
        success: function (data) {
          var myData = JSON.parse(data);
          if (myData.val == 1) {
            alertify.success(myData.msg);
          } else {
            alertify.error(myData.msg);
          }
        },
        error: function () {
          alertify.error("Beklenmedik bir hata oluştu");
        },
        contentType:false,
        processData: false

      })
}

function trackUploadProgress(e)
{
    if(e.lengthComputable)
    {
        currentProgress = (e.loaded / e.total) * 100;
        $("#excelprogress").width(currentProgress+'%');
        $("#autocreate-progress > span").html(parseInt(currentProgress)+'%');

    }
}