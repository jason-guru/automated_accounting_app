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
                <p id="formatHelp" class="form-text text-muted">The <b>first %s</b> in the sms & mail body is used to denote the <b>client's company name</b>. And the <b>second %s</b> is used to denote the next <b>accounts due date</b>. <br> <i>Example:</i> Hello %s, this is an account filing reminder. Your account's next due date is on %s. <br><i>Ouput:</i> Hello XYZ Corp, this is a account filing reminder. Your account's next due date is on 31-05-2020.</p>
            </div>
        </div>
    </div>
    </div><!--card-->
@endsection
