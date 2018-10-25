@extends('backend.layouts.app')

@section('title', 'Formats | Create Format')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Create New Format
                </h4>
            </div><!--col-->
        </div><!--row-->
        <hr>
        <form action="{{route('admin.message-formats.store')}}" method="post">
            @csrf
                <div class="form-group mt-4">
                    <label for="" class=" col-form-label">Name: <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for=""  class="col-form-label">SMS Body: <span class="text-danger">*</span></label>
                    <textarea name="sms_format" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for=""  class="col-form-label">Email Body: <span class="text-danger">*</span></label>
                    <textarea name="email_format" id="" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div class="form-group"><button type="submit" class="btn btn-success pull-right">Save</button></div>
        </form>
    </div><!--card-body-->
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <h5>Instruction:</h5>
                <p id="formatHelp" class="form-text text-muted"><b>Keyword Association</b>
                    <ul>
                        <li><b>%mail_to</b> = Director's name or company name if director name not present</li>
                        <li><b>%reference_number</b> = Gets the client's set reference number</li>
                        <li><b>%amount</b> = Gets the client's set amount</li>
                    </ul>
                    
                </p>
            </div>
        </div>
    </div>
    </div><!--card-->
@endsection
