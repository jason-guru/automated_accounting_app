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
            <div class="col-sm-5">
                <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
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
                                    Reminder Dates<span class="text-danger">*</span>
                                </th>
                                <th>Schedule Time<span class="text-danger">*</span></th>
                                <th>Reccurrence</th>
                                <th>Reference</th>
                                <th>Send SMS</th>
                                <th>Send Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($client->reminders as $reminder)
                                <tr>
                                    <td>
                                        {{$reminder->deadline->name}}
                                    </td>
                                    <td>
                                        <input data-toggle="datepicker" name="reminder_dates[]" id="" class="form-control" value="{{ Carbon\Carbon::parse($reminder->remind_date)->format('d-M-Y')}}" required>
                                    </td>
                                    <td>
                                        <input type="time" name="reminder_time[]" id="" class="form-control" value="{{$reminder->schedule_time}}" required>
                                    </td>
                                    <td>
                                        <select name="recurring_id[]" id="" class="form-control">
                                            <option value="">Select Reccurrence</option>
                                            @foreach ($recurrings as $recurring)
                                                <option value="{{$recurring->id}}" {{$reminder->recurring_id == $recurring->id ? "selected" : ""}}>{{$recurring->name}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <select name="reference_number_id[]" id="" class="form-control">
                                                <option value="">None</option>
                                                @foreach ($client->reference_numbers as $reference_number)
                                                    <option value="{{$reference_number->id}}" {{$reminder->reference_number_id == $reference_number->id ? "selected" : ""}}>{{$reference_number->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <label class="switch switch-label switch-pill switch-success mr-2" for="to-sms-{{$reminder->id}}">
                                        <input class="switch-input" data-id="{{$reminder->id}}" type="checkbox" name="send_sms[]" id="to-sms-{{$reminder->id}}" value="{{$reminder->send_sms}}" {{$reminder->send_sms == 1 ? "checked" : ""}} data-url="{{route('admin.reminders.switch.update', ['id' => $reminder->id])}}">
                                            <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-label switch-pill switch-success mr-2" for="to-email-{{$reminder->id}}">
                                        <input class="switch-input" data-id="{{$reminder->id}}" type="checkbox" name="send_email[]" id="to-email-{{$reminder->id}}" value="{{$reminder->send_email}}" {{$reminder->send_email == 1 ? "checked" : ""}} data-url="{{route('admin.reminders.switch.update', ['id' => $reminder->id])}}">
                                            <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                             <a href="{{route('admin.reminder.delete.from.edit', ['id' => $reminder->id])}}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                        </div>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Reminder to {{$client->company_name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{route('admin.reminder.create.from.edit')}}" method="post">
                @csrf
                <div class="modal-body">
                    <label for="">Deadline</label><span class="text-danger">*</span>
                    <select name="deadline_id" id="" class="form-control">
                        <option value="">Select a Deadline</option>
                        @foreach ($deadlines as $deadline)
                            <option value="{{$deadline->id}}">{{$deadline->name}}</option>
                        @endforeach
                    </select>
                    <div class="form-group">
                        <label for="">Reminder Date:</label><span class="text-danger">*</span>
                        <input class="form-control" type="date" name="remind_date">
                    </div>
                    <div class="form-group">
                        <label for="">Schedule Time:</label><span class="text-danger">*</span>
                        <input class="form-control" type="time" name="schedule_time">
                    </div>
                    <div class="form-group"><label for="">Recurring:</label>
                        <select name="recurring_id" id="" class="form-control">
                            <option value="">None</option>
                            @foreach ($recurrings as $recurring)
                                <option value="{{$recurring->id}}">{{$recurring->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group"><label for="">Refrence:</label>
                        <select name="reference_number_id" id="" class="form-control">
                            <option value="">None</option>
                            @foreach ($client->reference_numbers as $reference_number)
                                <option value="{{$reference_number->id}}">{{$reference_number->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Send SMS</th>
                                    <th>Send Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <label class="switch switch-label switch-pill switch-success mr-2" for="to-sms">
                                            <input class="switch-input" type="checkbox" name="send_sms" id="to-sms" checked>
                                                <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                                        </label>
                                    </td>
                                    <td>
                                        <label class="switch switch-label switch-pill switch-success mr-2" for="to-email">
                                            <input class="switch-input" type="checkbox" name="send_email" id="to-email" checked>
                                                <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                                        </label>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="has_reminded" value="0">
                    <input type="hidden" name="client_id" value="{{$client->id}}">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@endsection
