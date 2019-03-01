@extends('backend.layouts.app')

@section('title','Formats | Edit Format')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Edit Format
                </h4>
            </div><!--col-->
        </div><!--row-->
        <hr>
        <form action="{{route('admin.message-formats.update', ['id' => $message_format->id])}}" method="post">
            @csrf
            @method('PUT')
                <div class="form-group mt-4">
                    <label for="" class=" col-form-label">Name: <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="" class="form-control" value="{{$message_format->name}}"  placeholder="Enter a Format name">
                    <input type="hidden" name="id" value="{{$message_format->id}}">
                </div>
                <div class="form-group">
                    <label for=""  class="col-form-label">SMS Body: <span class="text-danger">*</span></label>
                    <textarea name="sms_format" id="sms_format" cols="30" rows="10" class="form-control">{!!$message_format->sms_format!!}</textarea>
                </div>
                <div class="form-group">
                    <label for=""  class="col-form-label">Email Body: <span class="text-danger">*</span></label>
                    <textarea name="email_format" id="email_format" cols="30" rows="10" class="form-control">{!!$message_format->email_format!!}</textarea>
                </div>
                <div class="form-group"><button type="submit" class="btn btn-success pull-right">Update</button></div>
        </form>
    </div><!--card-body-->
    <div class="card-footer">
        <div class="row">
            <div class="col-md-12">
                <h5>Instruction:</h5>
                <p id="formatHelp" class="form-text text-muted"><b>Keyword Association</b>
                    <ul>
                            <li><b>%mail_to:</b> Director's name or company name if director name not present</li>
                            <li><b>%reference_number:</b> Placeholder for client's reference number</li>
                            <li><b>%amount:</b> Placeholder for client's amount</li>
                            <li><b>%period_from:</b> Placeholder for period from date </li>
                            <li><b>%period_to:</b> Placeholder for period to date </li>
                            <li><b>%due_on:</b> Placeholder for due on date </li>
                    </ul>
                    
                </p>
            </div>
        </div>
    </div>
    </div><!--card-->
    @push('after-styles')
        <script src="https://cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
    @endpush
    @push('after-scripts')
        <script>
            CKEDITOR.replace( 'email_format' );
            CKEDITOR.replace( 'sms_format' );
        </script>
    @endpush
@endsection
