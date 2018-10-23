<div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>Name of the Deadline:</th>
                        <td>{{$deadline->name}}</td>
                    </tr>
                    <tr>
                        <th>Linked Message Format:</th>
                        <td>{{$deadline->message_format->name}}</td>
                    </tr>
                    <tr>
                        <th>SMS Format:</th>
                        <td>{{$deadline->message_format->sms_format}}</td>
                    </tr>
                    <tr>
                        <th>Email Format:</th>
                        <td>{{$deadline->message_format->email_format}}</td>
                    </tr>
                </table>
            </div><!--table-responsive-->
        </div>
    </div>