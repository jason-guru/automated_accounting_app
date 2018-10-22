// Loaded after CoreUI app.js
$('.switch-input').change(function(){
    var Id = $(this).data('id');
    var url;
    
    if($(this).attr('name') === 'remind[]'){
        if(Id){
            url = $(this).data('url');
            var remindValue;
            var messageType = null;
            if(this.checked){
                remindValue = 1;
                updateState(url, remindValue, messageType);
            }else{
                remindValue = 0;
                updateState(url, remindValue, messageType);
            }
        }
    }
    if($(this).attr('name') === 'send_sms[]'){
        if(Id){
            url = $(this).data('url');
            var sendSMS;
            var messageType = 'sms';
            if(this.checked){
                sendSMS = 1;
                updateState(url, sendSMS, messageType);
            }else{
                sendSMS = 0;
                updateState(url, sendSMS, messageType);
            }
        }
    }
    if($(this).attr('name') === 'send_email[]'){
        if(Id){
            url = $(this).data('url');
            var sendEmail;
            var messageType = 'email';
            if(this.checked){
                sendEmail = 1;
                updateState(url, sendEmail, messageType);
            }else{
                sendEmail = 0;
                updateState(url, sendEmail, messageType);
            }
        }
    }

});

function updateState(url, value, type){
    var method = "PUT";
    $.ajax({
        url: url,
        type: method,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'switch_value': value,
            'switch_value_update': true,
            'message_type' : type
        },
        dataType: "json",
        success: function(response){
            //
        },error: function(e){
            console.log(e);
        }
    });
}

$('#add-contact-person').click(function(e){
    e.preventDefault();
    var url = $('form#contact-modal-form').attr('action');
    var formData = $('form#contact-modal-form').serialize();
    $.ajax({
        url:url,
        type:'get',
        data: formData,
        dataType: 'json',
        success: function(response){
            $('table#contact-person-listing').css('display', 'table');
            $('table#contact-person-listing tbody').append(response.view);
        },error: function(e){
            console.log(e);
        }
    });
    $('#contactModal').modal('toggle');
});

$('[data-toggle="datepicker"]').datepicker({
    format: 'dd-m-yyyy',
    autoHide: true,
    }
);