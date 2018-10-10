@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Reminder Management <small class="text-muted">Active Reminders</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Client ID</th>
                            <th>Company Name</th>
                            <th>Frequency</th>
                            <th>First Reminder</th>
                            <th>Second Reminder</th>
                            <th>Third Reminder</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reminders as $reminder)
                            <tr>
                                <td>{{$reminder->client->company_number}}</td>
                                <td>{{$reminder->client->company_name}}</td>
                                <td>{{$reminder->frequency->name}}</td>
                                <td>{{$reminder->first_remind}}</td>
                                <td>{{$reminder->second_remind}}</td>
                                <td>{{$reminder->third_remind}}</td>
                                <td>{!!$reminder->is_active ? '<span class="bg-success px-2"><b>Active</b></span>' : '<span class="bg-danger px-1"><b>Inactive</b></span>'!!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $reminders->total() !!} {{ trans_choice('total reminder(s)', $reminders->total()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $reminders->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
