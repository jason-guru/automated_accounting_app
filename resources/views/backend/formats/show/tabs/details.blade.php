<div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>Name of format</th>
                        <td>{{$message_format->name}}</td>
                    </tr>
                    <tr>
                        <th>SMS Format</th>
                        <td>{!!$message_format->sms_format!!}</td>
                    </tr>
                    <tr>
                        <th>Email Format</th>
                        <td>{!!$message_format->email_format!!}</td>
                    </tr>
                </table>
            </div><!--table-responsive-->
        </div>
    </div>