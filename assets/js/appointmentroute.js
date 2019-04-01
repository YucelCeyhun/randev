alertify.set('notifier', 'position', 'top-center');
var map;
$(function(){
    $.PickDate();
    $("#searchButton").click(function(){
        var datepicker = $.trim($("#datepicker").val());
        var engineers = $.trim($("#engineers").val());
        $.getRouteSearchResult(datepicker,engineers)
    })
})

$.PickDate = function () {

    $("#datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        gotoCurrent: true,
    });

    $("#datepicker").datepicker($.datepicker.regional["tr"]);
    $("#datepicker").datepicker("option", "maxDate", "+1m");
    $("#datepicker").datepicker("option", "minDate", 0);
}

$.getRouteSearchResult = function(datepicker,engineers){
    var jdate ={
        datepicker : datepicker,
        engineers : engineers
    };
    $.ajax({
        url: "/ajax/AppointmentSearchRouteAjax/",
        type: "post",
        data: jdate,
        success: function (data) {
          var myData = JSON.parse(data);
          if (myData.val == 1) {

            $("#appointment-route-result").html(myData.msg)
           map = new google.maps.Map(document.getElementById('map'), {

              center: {
                lat: 39.8904939,
                lng: 32.83577508
              },
              zoom: 15,
              disableDefaultUI: true,
              fullscreenControl: true,
              rotateControl: true,
              mapTypeControl: true,
              mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                mapTypeIds: ['roadmap', 'satellite']
              }
            })
          } else {
            alertify.error(myData.msg);
          }

        },
        error: function () {
          alertify.error("Beklenmedik bir hata oluştu");
        }

      })
}