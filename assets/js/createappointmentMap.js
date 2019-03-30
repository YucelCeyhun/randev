alertify.set('notifier', 'position', 'top-center');
var windowInfo = null
var address = null;
var marker = null;
var map;
var geocoder;

function initMap() {
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
  geocoder = new google.maps.Geocoder();

  $("#adressBtn").click(function () {
    address = $("#addressfind").val();
    if (address != "") {
      $.MarkToFindAdress();
    }
  })
  $.MarkToClick();
}

$.MarkToClick = function MarkToClick() {
  map.addListener('click', function (e) {
    $.GetInputVal();
    if ($.controlValuesForMap(datepicker, builtname, companies, total, scaleTotal)) {
      var jdata = {
        datepicker: datepicker.val(),
        builtname: builtname.val(),
        companies: companies.val(),
        total: total
      };

      $.ajax({
        url: "/ajax/appointmentformajax/",
        type: "post",
        data: jdata,
        success: function (data) {
          var myData = JSON.parse(data);
          if (myData.val == 1) {
            $.marker(e.latLng);
            map.setZoom(18);
            geocoder.geocode({ 'location': marker.getPosition() }, function (results, status) {
              if (status === 'OK') {
                $.AttachInfoWindow('şuanki adres: <span>' + results[0].formatted_address + '</span>');
                $("#map-address").val(results[0].formatted_address);
                $("#map-address-latlng").val(results[0].geometry.location.lat() + "," + results[0].geometry.location.lng());
                $("#neighborhood").val(results[0].address_components[2].long_name);
                $("#district").val(results[0].address_components[3].long_name);
              } else {
                alertify.error('Hata oluştu ' + status);
              }
            });

          } else {
            alertify.error(myData.msg);
          }
        },
        error: function () {
          alertify.error("Beklenmedik bir hata oluştu");
        }

      })

    }
  })
}


$.MarkToFindAdress = function () {
  $.GetInputVal();
  if ($.controlValuesForMap(datepicker, builtname, companies, total, scaleTotal)) {
    var jdata = {
      datepicker: datepicker.val(),
      builtname: builtname.val(),
      companies: companies.val(),
      total: total
    };

    $.ajax({
      url: "/ajax/appointmentformajax/",
      type: "post",
      data: jdata,
      success: function (data) {
        var myData = JSON.parse(data);
        if (myData.val == 1) {

          geocoder.geocode({ 'address': address }, function (results, status) {
            if (status === 'OK') {

              map.setCenter(results[0].geometry.location);
              $.marker(results[0].geometry.location)
              map.setZoom(18);
              $.AttachInfoWindow('şuanki adres: <span>' + results[0].formatted_address + '</span>');
              $("#map-address").val(results[0].formatted_address);
              $("#map-address-latlng").val(results[0].geometry.location.lat() + "," + results[0].geometry.location.lng());
              $("#neighborhood").val(results[0].address_components[2].long_name);
              $("#district").val(results[0].address_components[3].long_name);

            } else {
              alertify.error('Hata oluştu ' + status);
            }

          });

        } else {
          alertify.error(myData.msg);
        }
      },
      error: function () {
        alertify.error("Beklenmedik bir hata oluştu");
      }

    })

  }
}

$.DrawCircle = function (map, postion) {
  new google.maps.Circle({
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#FF0000',
    fillOpacity: 0.35,
    map: map,
    center: postion,
    radius: 10
  });
}

$.AttachInfoWindow = function (content) {

  if (windowInfo == null) {
    windowInfo = new google.maps.InfoWindow();
  }
  windowInfo.setContent(content);
  windowInfo.open(map, marker);
}

$.marker = function (pos) {
  if (marker == null) {
    marker = new google.maps.Marker({
      map: map,
      position: pos,
      animation: google.maps.Animation.BOUNCE
    });
  }
  marker.setPosition(pos);
  map.setCenter(pos);
}

