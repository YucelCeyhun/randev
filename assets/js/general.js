$(window).on('load',function(){
   $("#loading-screen").fadeOut("slow");
})

$(function () {
   $('[data-toggle="tooltip"]').tooltip()
   $('[data-toggle="popover"]').popover()
 })
 
$.ajaxActionGif = function(element){
   
      $(document).ajaxSend(function() {
         $(element).html('<div id="wait-for-data" class="mx-auto my-auto"></div>');
      });
   

   $(document).ajaxComplete(function() {
      $("#wait-for-data").fadeOut("slow");
   });

}

