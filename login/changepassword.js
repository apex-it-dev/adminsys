$(function () {
     $("#txtOldPass").focus();
     $("#btnChangePass").on("click", function(){
        var oldpass = $("#txtOldPass").val();
        var newpass = $("#txtNewPass").val();
        var conpass = $("#txtConPass").val();
        if(oldpass == ""){
            alertDialog('Please enter your old password.');
            return false;
        }
        if(newpass == ""){
            alertDialog('Please enter your new password.');
            return false;
        }
        if(conpass == ""){
            alertDialog('Please enter your confirmation password.');
            return false;
        }
        if(newpass !== conpass){
            alertDialog('The new password and confirmation password do not match.');
            return false;
        }
        if(oldpass === newpass){
            alertDialog('Please enter a different password.');
            return false;
        }

        $.blockUI({ 
            message: $('#preloader_image'), 
            fadeIn: 1000, 
            onBlock: function() {
                ChangePassword();
            }
        });
    });
});

function ChangePassword(){
    var url = getAPIURL() + 'abauser.php';
    var f = "changePassword";
    var oldpass = $("#txtOldPass").val();
    var newpass = $("#txtNewPass").val();
    // var conpass = $("#txtConPass").val();
    var abaini = $("#txtUser").val();
    var data = { "f":f, "opw":oldpass, "npw":newpass, "abaini":abaini };
    // console.log(url);

    $.ajax({
        type: 'POST',
        url: url,
        data: JSON.stringify({ "data":data }),
        dataType: 'json'
        ,success: function(data){
            // console.log(data);
            var err = data['err'];
            var errmsg = data['errmsg'];
            if(err == 1){
                alertDialog(errmsg);
               $.unblockUI();
               return false;
            }
            alertDialog(errmsg);
            $("#changePassword").modal('hide');
            clearfields();
            $.unblockUI();
        }
        ,error: function(request, status, err){

        }
    });
}

function clearfields(){
    $("#txtOldPass").val('');
    $("#txtNewPass").val('');
    $("#txtConPass").val('');
}