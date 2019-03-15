/**
 * Created by feb on 02/10/17.
 */

var interval = 1200; //seconds

function syncToServer() {
    $("#sync_info").html("<i class=\"em em-repeat\"></i> Processing..");
    $.ajax({
        url : syncUrl,
        dataType: "json",
        success: function (data) {
            if(data.status == "OK") {
                $("#sync_info").html("<i class=\"em em-white_check_mark\"></i> " + data.message);
            }else{
                $("#sync_info").html("<i class=\"em em-warning\"></i> " + data.message);
            }
        }
    });
}

setInterval(syncToServer, interval * 1000);
syncToServer();