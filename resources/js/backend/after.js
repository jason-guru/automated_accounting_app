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
