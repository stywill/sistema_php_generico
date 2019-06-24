$(document).ready(function () {   
    $("#clogin").validate({
       
        rules: {
            login: {
                required: true
            },
            senha: {
                required: true
            }
        },
        messages: {
            login: "Informe seu Usuario.",
            senha: "Informe sua senha."
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            error.appendTo($("#" + name + "_validate"));  
        }
    });
    
});

