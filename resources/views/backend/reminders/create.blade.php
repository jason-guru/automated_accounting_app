@extends('backend.layouts.app')

@section('title', 'Reminders | Create Reminder')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Create New Reminder
                </h4>
            </div><!--col-->
        </div><!--row-->
        <hr>
        <form action="{{route('admin.reminders.store')}}" method="post">
            @csrf
            <reminder-form :deadlines='{{$deadlines}}' :clients='{{$clients}}' :recurrings='{{$recurrings}}'></reminder-form>
        </form>
    </div><!--card-body-->
    </div><!--card-->
@endsection
