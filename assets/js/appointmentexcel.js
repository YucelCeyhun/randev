alertify.set('notifier', 'position', 'top-center');
$(function(){
    $.PickDate();

    var dateFormat =  "dd-mm-yy";
    $("#datepickerFrom").on( "change", function() {
        date = $.datepicker.parseDate( dateFormat, $("#datepickerFrom").val());
        $("#datepickerTo").datepicker("option", "minDate", date);
      })

    $("#createBtn").click($.createExcel);
    $.InputRemoveClass();
})

$.PickDate = function () {

    $("#datepickerFrom").datepicker({
        dateFormat: "dd-mm-yy",
        gotoCurrent: true,
    });

    $("#datepickerTo").datepicker({
        dateFormat: "dd-mm-yy",
        gotoCurrent: true,
    });


    $("#datepickerFrom").datepicker($.datepicker.regional["tr"]);
    $("#datepickerFrom").datepicker("option", "maxDate", "+1m");
    $("#datepickerFrom").datepicker("option", "minDate", 0);

    $("#datepickerTo").datepicker($.datepicker.regional["tr"]);
    $("#datepickerTo").datepicker("option", "maxDate", "+1m");
    $("#datepickerTo").datepicker("option", "minDate", 0);
    
}

$.createExcel = function(){

  var datepickerFrom = $("#datepickerFrom");
  var datepickerTo = $("#datepickerTo");
  var engineers = $("#engineers");

  datepickerFrom.val($.trim(datepickerFrom.val()));
  datepickerTo.val($.trim(datepickerTo.val()));
  engineers.val($.trim(engineers.val()));

  var formInput = Array(datepickerFrom, datepickerTo, engineers);
  if ($.InputEmtypControl(formInput)) {
    $.ajax({
        url: "/ajax/AppointmentExcelListAjax/",
        type: "post",
        data: {datepickerFrom : datepickerFrom.val(),datepickerTo : datepickerTo.val(),engineers : engineers.val()},
        success: function (data) {
         var myData = JSON.parse(data);
          if (myData.val == 1) {
            alertify.success(myData.msg);
            $("form").submit();
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








