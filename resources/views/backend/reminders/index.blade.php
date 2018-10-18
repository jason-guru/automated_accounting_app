@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('labels.backend.access.users.management'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Reminder Management <small class="text-muted">Active Reminders</small>
                </h4>
            </div><!--col-->
            <div class="col-sm-5">
                @include('backend.reminders.includes.header-buttons')
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
                            <th>Total Reminders</th>
                            <th>Total Reminded</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($reminder_data as $reminder)
                                <tr>
                                    <td>{{$reminder['client_id']}}</td>
                                    <td>{{$reminder['company_name']}}</td>
                                    <td>{{$reminder['total_reminders']}}</td>
                                    <td>{{$reminder['total_reminded']}}</td>
                                    <td>{!!$reminder['actions']!!}</td>
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
                    {!! $reminder_data->count() !!} {{ trans_choice('total reminder(s)', $reminder_data->count()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $reminder_data->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
