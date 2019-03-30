window.onload = function() {
    $.ajax({
        url: "/ajax/DefaultPanelAjax/",
        type: "post",
        success: function (data) {
            var myData = JSON.parse(data);
            var ctx = document.getElementById('chart-area').getContext('2d');
            window.myPie = new Chart(ctx, myData.config);
            $("#chart-table").html(myData.table)
        }
    })
    //alert(config.data.datasets[0].data);
};