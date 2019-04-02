$(function(){
  $.ajaxAction("#createBtn");
  $("#engineerBtn").click($.LoadData);
  $("#createBtn").click($.InsertData);
  $.ajaxActionGif("#engineer-select");
})


$.LoadData = function(){

    if(!$("#collapseEngineer").hasClass("show")){
        $.GetInputValExtra();
        if ($.controlValuesForMapExtra(datepicker, builtname, companies, total, scaleTotal,address,latlng,neighborhood,district)) {
          var jdata = {
            datepicker: datepicker.val(),
            builtname: builtname.val(),
            companies: companies.val(),
            total: total,
            address: address.val(),
            latlng : latlng.val(),
            neighborhood : neighborhood.val(),
            district : district.val()
          };
          
          $.ajax({
            url: "/ajax/appointmentselectajax/",
            type: "post",
            data: jdata,
            success: function (data) {
              var myData = JSON.parse(data);
              if (myData.val == 1) {
                $("#engineer-select").html(myData.tableList);
              } else {
                alertify.error(myData.msg);
                $("#engineer-select").html('<div class="alert alert-danger text-center" role="alert">Bu alanı görüntülemek için önce hataları giderin.</div>')
              }
            },
            error: function () {
              alertify.error("Beklenmedik bir hata oluştu");
            }
    
          })
    
        }else{
           $("#engineer-select").html('<div class="alert alert-danger text-center" role="alert">Bu alanı görüntülemek için önce hataları giderin.</div>')
        }
    }
}

$.InsertData = function(){
      $(".collapse").removeClass("show");
      $.GetInputValLast();
      if ($.controlValuesForMapLast(datepicker, builtname, companies, total,scaleTotal,address,latlng,neighborhood,district,engineers)) {
        var jdata = {
          datepicker: datepicker.val(),
          builtname: builtname.val(),
          companies: companies.val(),
          total: total,
          address: address.val(),
          latlng : latlng.val(),
          neighborhood : neighborhood.val(),
          district : district.val(),
          engineers: engineers.val(),
          controlen : controlen.val(),
          controlee : controlee.val()
        };
        
        $.ajax({
          url: "/ajax/appointmentcreateajax/",
          type: "post",
          data: jdata,
          success: function (data) {
            var myData = JSON.parse(data);
            if (myData.val == 1) {
              alertify.success(myData.msg);
              $.Redirect(myData.urlDirect);
              $.DisElement("#createBtn");
              $.DisElement("#engineerBtn");
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

