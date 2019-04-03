alertify.set('notifier', 'position', 'top-center');
var map;
var directionsDisplay = [];
var directionsService = [];
var routeList = [];
var colors = ['#4f6ced','#c9b2eb','#e6df44','#26b28a','#5e0756','#0f2171','#f0810f','#c19a6b','#930600','#405773']; 

$(function(){
    $.PickDate();
    $("#searchButton").click(function(){
        var datepicker = $.trim($("#datepicker").val());
        var engineers = $.trim($("#engineers").val());
        $.getRouteSearchResult(datepicker,engineers)
    })
    $.ajaxActionGif("#appointment-route-result");

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
            if(myData.result.length > 0){
              $("#appointment-route-result").html(myData.msg + '<div id="routelist-main"></div>');
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                  lat: parseInt(myData.engineer.lat),
                  lng: parseInt(myData.engineer.lng)
                },
                zoom: 12,
                disableDefaultUI: true,
                fullscreenControl: true,
                rotateControl: true,
                mapTypeControl: true,
                mapTypeControlOptions: {
                  style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                  mapTypeIds: ['roadmap', 'satellite']
                }
              })

        
              $.each( myData.result, function(i,val) {
                $.drawRoute (i,myData.result.length);
                if(i == 0){  
                  $.calculateAndDisplayRoute(directionsService[i], directionsDisplay[i], 
                  myData.engineer.lat + "," + myData.engineer.lng,myData.result[i].lat + "," + myData.result[i].lng,myData,i);
                  $.marker(myData.engineer.lat,myData.engineer.lng,i);
                }else{
                  $.calculateAndDisplayRoute(directionsService[i], directionsDisplay[i], 
                  myData.result[i-1].lat + "," + myData.result[i-1].lng,myData.result[i].lat + "," + myData.result[i].lng,myData,i);
                  $.marker(myData.result[i-1].lat,myData.result[i-1].lng,i);
                 if(i == (myData.result.length-1))
                    $.marker(myData.result[i].lat,myData.result[i].lng,i+1);
                }
                
              });
            }else{
              $("#appointment-route-result").html("Bu tarihde mühendisin randevusu bulunamadı.")
            }
            $( "#routelist-main").sortable();
            $( "#routelist-main" ).disableSelection();
          } else {
            alertify.error(myData.msg);
          }

        },
        error: function () {
          alertify.error("Beklenmedik bir hata oluştu");
        }

      })
}


$.calculateAndDisplayRoute = function(service, display, origin, destination,myData,i) {
  service.route({
    origin: origin,
    destination: destination,
    travelMode: 'DRIVING',
    unitSystem: google.maps.UnitSystem.METRIC
  }, function(response, status) {
    if (status === 'OK') {
      display.setDirections(response);
      var infoList = $.PutRouteList(myData,response.routes[0].legs[0].distance.text,response.routes[0].legs[0].duration.text,i);
      $("#routelist-main").html($("#routelist-main").html() + infoList);
    } else {
      window.alert('Directions request failed due to ' + status);
    }
  });
}

$.drawRoute = function(arrayIndex,length){
  
  var polyline = new google.maps.Polyline({
    strokeColor: colors[arrayIndex],
    strokeOpacity: 0.7,
    strokeWeight: 10
    });
    
    directionsDisplay[arrayIndex] = new google.maps.DirectionsRenderer({
      map:map,
      polylineOptions:polyline,
      suppressMarkers: true
  });

  directionsService[arrayIndex] = new google.maps.DirectionsService;
}

$.AttachInfoWindow = function (content) {

  if (windowInfo == null) {
    windowInfo = new google.maps.InfoWindow();
  }
  windowInfo.setContent(content);
  windowInfo.open(map, marker);
}

$.PutRouteList = function(myData,distance,duration,i){
  var returnedVal = '<ul class="list-group" style="background:'+colors[i]+'">'+'<li class="list-group-item d-flex justify-content-between">'+'<div>'+
  '<h5 class="mb-1">'+myData.result[i].builtName+'</h5>'+
      '<p class="mb-0">Mesafe : '+distance+'</p>'+
      '<p class="mb-0">Yolda geçecek süre : '+duration+'</p>'+
    '<p class="mb-0">Hedef adres : '+myData.result[i].address+'</p>'+
    '<p class="mb-0">Firma : '+myData.result[i].name+'</p></div>'+
    '<div class="sort-index my-auto">'+(i == 0 ?'E':i)+' <i class="fas fa-arrow-right"></i> '+(i+1)+'</div>'+
  '</li></ul>';
  return returnedVal;

}

$.marker = function (lat,lng,img) {
    new google.maps.Marker({
      map: map,
      position: {  
        lat: parseFloat(lat),
        lng: parseFloat(lng)
      },
      animation: google.maps.Animation.BOUNCE,
      icon:{
        url : "http://localhost/assets/images/mapicons/"+img+".png"
      }
    });
}



