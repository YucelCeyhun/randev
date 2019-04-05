alertify.set('notifier','position', 'top-center');
$(window).on('load',function(){
   $("#loading-screen").fadeOut("slow");
})

$(function () {
   $('[data-toggle="tooltip"]').tooltip()
   $('[data-toggle="popover"]').popover()

   $('#sidebarCollapse').on('click', function () {
      $(".sidebar").toggleClass("sideCollapse");
   });

   $("#AExit").click($.ajaxExit);

 })
 
$.ajaxActionGif = function(element){
   
      $(document).ajaxSend(function() {
         $(element).html('<div id="wait-for-data" class="mx-auto my-auto"></div>');
      });
   

   $(document).ajaxComplete(function() {
      $("#wait-for-data").fadeOut("slow");
   });

}

$.ajaxExit = function(){
   $.ajax({
      url: "/ajax/ExitAjax/",
      type: "post",
      success: function (data) {
        var myData = JSON.parse(data);
        if (myData.val == 1) {
         alertify.success(myData.msg);
         $.Redirect(myData.urlDirect);
        } else {
          alertify.error(myData.msg);
        }
      },
      error: function () {
        alertify.error("Beklenmedik bir hata oluştu");
      }

    })
}

