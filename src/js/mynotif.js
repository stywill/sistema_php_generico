$(document).ready(function () {
    checknotifJ();
    
    setInterval(function () {
        checknotifJ();
    }, 30000);
    checknotifS();
    setInterval(function () {
        checknotifS();
    }, 30000);
});
function checknotifJ() {
    if (!Notification) {
        $('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
        return;
    }
    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        $.ajax(
                {
                    url: "src/pushJ.php",
                    type: "POST",
                    success: function (data, textStatus, jqXHR)
                    {
                        var data = jQuery.parseJSON(data);
                        if (data.result == true) {
                            var data_notif = data.notif;
                            for (var i = data_notif.length - 1; i >= 0; i--) {
                                console.log(data_notif[i]['msg'])
                                var theurl = data_notif[i]['url'];
                                var notifikasi = new Notification(data_notif[i]['title'], {
                                    icon: data_notif[i]['icon'],
                                    body: data_notif[i]['msg'],
                                });
                                notifikasi.onclick = function () {
                                    window.open(theurl);
                                    notifikasi.close();
                                };
                                setTimeout(function () {
                                    notifikasi.close();
                                }, 12000);
                            }
                            ;
                        } else {

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {

                    }
                });
    }
};
function checknotifS() {
    if (!Notification) {
        $('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
        return;
    }
    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        $.ajax(
                {
                    url: "src/pushS.php",
                    type: "POST",
                    success: function (data, textStatus, jqXHR)
                    {
                        var data = jQuery.parseJSON(data);
                        if (data.result == true) {
                            var data_notif = data.notif;
                            for (var i = data_notif.length - 1; i >= 0; i--) {
                                console.log(data_notif[i]['msg'])
                                var theurl = data_notif[i]['url'];
                                var notifikasi = new Notification(data_notif[i]['title'], {
                                    icon: data_notif[i]['icon'],
                                    body: data_notif[i]['msg'],
                                });
                                notifikasi.onclick = function () {
                                    window.open(theurl);
                                    notifikasi.close();
                                };
                                setTimeout(function () {
                                    notifikasi.close();
                                }, 12000);
                            }
                            ;
                        } else {

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {

                    }
                });
    }
};