// Loaded after CoreUI app.js
$('.switch-input').change(function(){
    var clientId = $(this).data('id');
    var url = $(this).data('url');
    if(clientId){
        var remindValue;
        if(this.checked){
            remindValue = 1;
            updateRemindState(url, remindValue);
        }else{
            remindValue = 0;
            updateRemindState(url, remindValue);
        }
    }
});

function updateRemindState(url, remindValue){
    var method = "PUT";
    $.ajax({
        url: url,
        type: method,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'remind': remindValue,
            'remind_update': true
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