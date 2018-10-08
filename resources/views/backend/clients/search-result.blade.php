@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">
            Details
        </h4>
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header">
                Basic Info
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Client ID</label>
                        <input name="client_id" type="text" class="form-control" value="{{$client_data['company_number']}}">
                        </div>

                        <div class="form-group">
                            <label for="">Client Type</label>
                        <input name="client_type" type="text" class="form-control" value="{{$client_data['type']}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Company Name</label>
                        <input name="company_name" type="text" class="form-control" value="{{$client_data['company_name']}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   
@endsection
