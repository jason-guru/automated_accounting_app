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
                    Create New Reminder
                </h4>
            </div><!--col-->
        </div><!--row-->
        <hr>
        <form action="{{route('admin.reminders.store')}}" method="post">
            @csrf
                <div class="form-group mt-4">
                    <label for="" class=" col-form-label">Select Client: <span class="text-danger">*</span></label>
                    <select name="client_id" id="" class="form-control">
                        @foreach ($clients as $client)
                            <option value="{{$client->id}}">{{$client->company_name}}</option>
                        @endforeach
                    </select>
                </div>
                <reminder-table :deadlines='{{$deadlines}}'></reminder-table>
                <input type="hidden" name="has_reminded" value="0">
                <div class="form-group"><button type="submit" class="btn btn-success pull-right">Save</button></div>
        </form>
    </div><!--card-body-->
    </div><!--card-->
@endsection
