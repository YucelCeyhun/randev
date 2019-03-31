alertify.set('notifier', 'position', 'top-center');
$(function(){
    $(".delete-appointment").click(function(){
        var elementatt = $(this).attr('id');
        var elementsp = elementatt.split("delete-appointment-");
        var elementId = $.trim(elementsp[1]);

        alertify.confirm('Randevu Silinsin mi ?',function(){
            $.ajax({
                url: "/ajax/AppointmentDeleteAjax/",
                type: "post",
                data: {elementId : elementId},
                success: function (data) {
                  var myData = JSON.parse(data);
                  if (myData.val == 1) {
                    alertify.success(myData.msg);
                    $.Reload();
                  } else {
                    alertify.error(myData.msg);
                  }
      
                },
                error: function () {
                  alertify.error("Beklenmedik bir hata oluştu");
                }
        
              })
        }).set('labels', {ok:'Sil', cancel:'İptal'})
        .setHeader('Randevu Sil');  

    })
    
})

