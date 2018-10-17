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
                    Deadline Management <small class="text-muted">Active Deadlines</small>
                </h4>
            </div><!--col-->
            <div class="col-sm-5">
                @include('backend.deadlines.includes.header-buttons')
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
                            <th>Message Format</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($deadlines as $deadline )
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$deadline->name}}</td>
                                <td>{{$deadline->message_format->name}}</td>
                                <td>{!!$deadline->action_buttons!!}</td>
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
