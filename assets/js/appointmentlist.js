alertify.set('notifier', 'position', 'top-center');
$(function(){
    $(".delete-appointment").click(function(){
        var elementId = $(this).attr('id');
        var elementsp = elementId.split("delete-appointment-");
        //alert(elementsp[1]);

        alertify.confirm('Randevu Silinsin mi ?',function(){
            alertify.success('Ok');
        },
        function(){
            alertify.error('Cancel');
        }).set('labels', {ok:'Sil', cancel:'İptal'})
        .setHeader('Randevu Sil');  

    })
    
})

