socket.emit("login_as_jaringan", {id: currentUserId});

socket.on("reconnect", function () {
    console.log("client reconnect to server");
    socket.emit("login_as_jaringan", {id: currentUserId});
});

var currentOrderID = null;

socket.on("new_order", function(msg){
    currentOrderID = msg.data_id;

    $.notify({
        title: msg.message,
        button: 'Confirm'
    }, {
        style: 'foo',
        autoHide: false,
        clickToHide: false
    });
});

$.notify.addStyle('foo', {
    html:
    "<div>" +
    "<div class='clearfix'>" +
    "<div class='title' data-notify-html='title'/>" +
    "<div class='buttons'>" +
    "<button class='no'>Cancel</button>" +
    "<button class='yes' data-notify-text='button'></button>" +
    "</div>" +
    "</div>" +
        "<div style='clear: both;'></div> "+
    "</div>"
});

$(document).on('click', '.notifyjs-foo-base .no', function() {
    //programmatically trigger propogating hide event
    $(this).trigger('notify-hide');
});
$(document).on('click', '.notifyjs-foo-base .yes', function() {
    //loadUrl("#"+baseUrl+"/plaza-pesanan/index");
    $.ajax({
        url : baseUrl+"/plaza-pesanan/accept/?id="+currentOrderID,
        dataType : "json",
        success : function (msg) {
            if(msg.status == "OK") {
                $.notify("Pesanan Berhasil Disetujui.", "success");
            }else{
                $.notify("Pesanan Gagal Disetujui.", "error");
            }
        }
    })
    $(this).trigger('notify-hide');
});