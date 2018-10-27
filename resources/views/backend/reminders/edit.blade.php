@extends('backend.layouts.app')

@section('title', 'Reminders | Edit Reminder')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Edit Reminder
                </h4>
            </div><!--col-->
        </div><!--row-->
        <hr>
        <form action="{{route('admin.reminders.update', ['id'=> $client->id])}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group mt-4">
                    <label for="" class="col-form-label">Select Client: <span class="text-danger">*</span></label>
                    <select name="client_id" id="" class="form-control" readonly disabled>
                        <option value="{{$client->id}}">{{$client->company_name}}</option>
                    </select>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    Deadline
                                </th>
                                <th>
                                    Reminder Dates
                                </th>
                                <th>Schedule Time</th>
                                <th>Reccurrence</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($client->reminders as $reminder)
                                <tr>
                                    <td>
                                        {{$reminder->deadline->name}}
                                    </td>
                                    <td>
                                        <input data-toggle="datepicker" name="reminder_dates[]" id="" class="form-control" value="{{ Carbon\Carbon::parse($reminder->remind_date)->format('d-M-Y')}}">
                                    </td>
                                    <td>
                                        <input type="time" name="reminder_time[]" id="" class="form-control" value="{{$reminder->schedule_time}}">
                                    </td>
                                    <td>
                                        <select name="recurring_id[]" id="" class="form-control">
                                            <option value="">Select Reccurrence</option>
                                            @foreach ($recurrings as $recurring)
                                                <option value="{{$recurring->id}}" {{$reminder->recurring_id == $recurring->id ? "selected" : ""}}>{{$recurring->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <input type="hidden" name="client_id" value="{{$client->id}}">
                <div class="form-group"><button type="submit" class="btn btn-success pull-right">Update</button></div>
        </form>
    </div><!--card-body-->
    </div><!--card-->
@endsection
