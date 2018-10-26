<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>Deadline Name</th>
                    <th>Reminder Date</th>
                    <th>Schedule Time</th>
                </tr>
                
                @foreach ($client->reminders as $reminder)
                <tr>
                    <td>{{$reminder->deadline->name}}</td>
                    <td>{{Carbon\Carbon::parse($reminder->remind_date)->format('d-m-y')}}</td>
                    <td>{{Carbon\Carbon::parse($reminder->schedule_time)->format('h:m A')}}</td>
                </tr>
                @endforeach
                
                
            </table>
        </div><!--table-responsive-->
    </div>
</div>