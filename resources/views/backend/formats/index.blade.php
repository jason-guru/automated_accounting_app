@extends('backend.layouts.app')

@section('title', 'Formats | Active Formats')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Notification Format Management <small class="text-muted">Active Formats</small>
                </h4>
            </div><!--col-->
            <div class="col-sm-5">
                @include('backend.formats.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>SMS Format</th>
                            <th>Email Format</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($message_formats as $message_format)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$message_format->name}}</td>
                                    <td>{!!substr($message_format->sms_format, 0, 10)!!}</td>
                                    <td>{!!substr($message_format->email_format, 0, 10)!!}</td>
                                    <td>{!!$message_format->action_buttons!!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
