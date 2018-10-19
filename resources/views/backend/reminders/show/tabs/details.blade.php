<div class="row">
    <div class="col-md-8">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Company Name</th>
                    <td>{{$client->company_name}}</td>
                </tr>
                @foreach ($client->reminders as $reminder)
                <tr>
                    <th>{{$reminder->deadline->name}}</th>
                    <td>{{$reminder->remind_date}}</td>
                </tr>
                @endforeach
                
                
            </table>
        </div><!--table-responsive-->
    </div>
</div>