alertify.set('notifier', 'position', 'top-center');
var datepicker = $("#datepicker");
var builtname = $("#builtname");
var companies = $("#companies");
var total = parseFloat($("#controlee").val()) + parseInt($("#controlen").val());
var controlee = $("#controlee");
var controlen = $("#controlen");
var scaleTotal = parseInt($("#controlen-scale").html()) + (parseFloat($("#controlee-scale").html()) / 2);
var address = $("#map-address");
var latlng = $("#map-address-latlng");
var neighborhood = $("#neighborhood");
var district = $("#district");

$(function () {
    $("#controlen").on('change', function () {
        var max = 5;
        var controle = parseInt($(this).val());
        $("#controlee").prop("max", max - controle);
        $("#controlen-scale").html(controle);
    })
    $("#controlee").on('change', function () {
        var max = 5;
        var controle = parseFloat($(this).val());
        $("#controlen").prop("max", max - controle);
        $("#controlee-scale").html(2 * controle);
    })
    $.PickDate();
    $.InputRemoveClass();
});

$.controlValuesForMap = function (datepicker, builtname, companies, total, scaleTotal) {
    datepicker.val($.trim(datepicker.val()))
    builtname.val($.trim(builtname.val()))
    companies.val($.trim(companies.val()))

    var formInput = Array(datepicker, builtname, companies);
    if ($.InputEmtypControl(formInput)) {
        if (total < 0.5 || total > 5) {
            alertify.error("Asansör adedi belirleyin.");
            return false;
        } else if (total != scaleTotal) {
            alertify.error("Asansör adedinde sorun var.");
            return false;
        }

        return true;
    }

    return false;
}

$.controlValuesForMapExtra = function (datepicker, builtname, companies, total, scaleTotal,address,latlng,neighborhood,district) {
    datepicker.val($.trim(datepicker.val()))
    builtname.val($.trim(builtname.val()))
    companies.val($.trim(companies.val()))
    address.val($.trim(address.val()))
    latlng.val($.trim(latlng.val()))
    neighborhood.val($.trim(neighborhood.val()))
    district.val($.trim(district.val()))

    var formInput = Array(datepicker, builtname, companies, address, latlng,neighborhood,district);
    if ($.InputEmtypControl(formInput)) {
        if (total < 0.5 || total > 5) {
            alertify.error("Asansör adedi belirleyin.");
            return false;
        } else if (total != scaleTotal) {
            alertify.error("Asansör adedinde sorun var.");
            return false;
        }

        return true;
    }

    return false;
}

$.controlValuesForMapLast = function (datepicker, builtname, companies, total, scaleTotal,address,latlng,neighborhood,district,engineers) {
    datepicker.val($.trim(datepicker.val()))
    builtname.val($.trim(builtname.val()))
    companies.val($.trim(companies.val()))
    address.val($.trim(address.val()))
    latlng.val($.trim(latlng.val()))
    neighborhood.val($.trim(neighborhood.val()))
    district.val($.trim(district.val()))

    if(engineers == null){
        alertify.error("Mühendis belirleyin.");
        return false;
    }

    engineers.val($.trim(engineers.val()))

    var formInput = Array(datepicker, builtname, companies, address, latlng, engineers);
    if ($.InputEmtypControl(formInput)) {
        if (total < 0.5 || total > 5) {
            alertify.error("Asansör adedi belirleyin.");
            return false;
        } else if (total != scaleTotal) {
            alertify.error("Asansör adedinde sorun var.");
            return false;
        }

        return true;
    }

    return false;
}


$.PickDate = function () {

    $("#datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        gotoCurrent: true,
    });

    $("#datepicker").datepicker($.datepicker.regional["tr"]);
    $("#datepicker").datepicker("option", "maxDate", "+1m");
    $("#datepicker").datepicker("option", "minDate", 0);
}

$.GetInputVal = function () {
    datepicker = $("#datepicker");
    builtname = $("#builtname");
    companies = $("#companies");
    total = parseFloat($("#controlee").val()) + parseInt($("#controlen").val());
    scaleTotal = parseInt($("#controlen-scale").html()) + (parseFloat($("#controlee-scale").html()) / 2);
}

$.GetInputValExtra = function () {
    datepicker = $("#datepicker");
    builtname = $("#builtname");
    companies = $("#companies");
    total = parseFloat($("#controlee").val()) + parseInt($("#controlen").val());
    scaleTotal = parseInt($("#controlen-scale").html()) + (parseFloat($("#controlee-scale").html()) / 2);
    address = $("#map-address");
    latlng = $("#map-address-latlng");
    neighborhood = $("#neighborhood");
    district = $("#district");
}

$.GetInputValLast = function(){
    datepicker = $("#datepicker");
    builtname = $("#builtname");
    companies = $("#companies");
    total = parseFloat($("#controlee").val()) + parseInt($("#controlen").val());
    scaleTotal = parseInt($("#controlen-scale").html()) + (parseFloat($("#controlee-scale").html()) / 2);
    address = $("#map-address");
    latlng = $("#map-address-latlng");
    neighborhood = $("#neighborhood");
    district = $("#district");
    controlee = $("#controlee");
    controlen = $("#controlen");
    
    if($("#engineers").length){
        engineers = $("#engineers");
    }else{
        engineers = null;
    }
}
