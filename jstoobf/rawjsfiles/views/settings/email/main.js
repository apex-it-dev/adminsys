$(async function() {
    $('#smtpsecure_select')
        .off('change')
        .on('change', e => {
            $('#smtpsecure_custom')
                .val('')
                .attr('disabled', !(e.target.value === ''));
        });

    $('#save_email_settings').off('click');

    $('#host, #port, #username, #password, #smtpsecure_select, #smtpsecure_custom, #smtpauth, #from')
        .on('change', e => {
            const isDisabled = $('#host').val() == '' || 
                                $('#port').val() == '' || 
                                $('#username').val() == '' || 
                                ($('#smtpsecure_select').val() == '' && $('#smtpsecure_custom').val() == '') ||
                                $('#from').val() == '';
            $('#save_email_settings').attr('disabled', isDisabled);
            $('#save_email_settings').off('click');
            if(!isDisabled) $('#save_email_settings').on('click', e => blockUI(() => saveEmailSettings()));
        });

    blockUI(() => {
        getEmailSettings();
    });
});

async function getEmailSettings() {
    let getdata = await qryData('emailsettings', 'getEmailSettings');
    const data = getdata.data;
    
    if(!getdata.success) {
        console.log(qrydata.msg);
        $.unblockUI();
        return;
    }

    const emailsettings = data.emailsettings.rows[0];

    $('#from').val(emailsettings.from);
    $('#host').val(emailsettings.host);
    $('#port').val(emailsettings.port);
    $('#username').val(emailsettings.username);


    const smtplist = $('#smtpsecure_select').children(); 
    let newsmtplist = [];
    smtplist.map(eachitem => newsmtplist.push(smtplist[eachitem].value));
    if(newsmtplist.includes(emailsettings.SMTPSecure)) {
        $('#smtpsecure_select').val(emailsettings.SMTPSecure);
    } else {
        $('#smtpsecure_select').val('');
        $('#smtpsecure_custom').val(emailsettings.SMTPSecure);
    }
    $('#smtpsecure_select').trigger('change');

    $('#smtpauth').attr('checked', emailsettings.SMTPAuth == 1);

    $.unblockUI();
}

async function saveEmailSettings() {
    await qryData('emailsettings', 'saveEmailSettings', {
        host:       $('#host').val(),
        port:       $('#port').val(),
        username:   $('#username').val(),
        password:   $('#password').val(),
        smtpsecure: $('#smtpsecure_select').val() !== '' ? $('#smtpsecure_select').val() : $('#smtpsecure_custom').val(),
        smtpauth:   $('#smtpauth').prop('checked') ? 1 : 0,
        from:       $('#from').val(),
        modifiedby: $('#userid').val(),
    });

    $('#password').val('');
    $.unblockUI();
}