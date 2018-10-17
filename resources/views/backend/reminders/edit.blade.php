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
                    Edit Reminder <small class="text-muted">Manually Set Reminder</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <form action="{{route('admin.reminders.update', ['id' => $reminder['id']])}}" method="post">
        @method('PUT')
        @csrf
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">First Reminder <span class="text-danger">*</span></label>
                    <input data-toggle="datepicker" class="form-control" value="{{$reminder['first_remind']}}" name="first_remind">
                </div>
            </div><!--col-->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Second Reminder</label>
                    <input  data-toggle="datepicker" class="form-control" value="{{$reminder['second_remind']}}" name="second_remind">
                </div>
            </div><!--col-->
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Third Reminder</label>
                    <input data-toggle="datepicker" class="form-control" value="{{$reminder['third_remind']}}" name="third_remind">
                    <input type="hidden" name="manual_mode" value="1">
                </div>
            </div><!--col-->
            <div class="col-md-12">
                <button class="btn btn-success btn-sm" type="submit">Update</button>
            </div>
        </div><!--row-->
        </form>
    </div><!--card-body-->
</div><!--card-->
@endsection
