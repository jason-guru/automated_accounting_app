@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                <strong>My Message & E-mail Body Formats</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('admin.dealines.format.store_update')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="sms_format">SMS Body</label>
                                    <textarea name="sms_format" id="sms_format" cols="30" rows="3" class="form-control">{{$format->sms_format}}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="email_format">E-mail Body</label>
                                        <textarea name="email_format" id="email_format" cols="30" rows="3" class="form-control" >{{$format->email_format}}</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="is_active" value=1>
                                <button class="btn btn-success pull-right" type="submit">Save Format</button>
                            </form>
                        </div>
                    </div>
                    
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
        </div><!--col-->
    </div><!--row-->
@endsection
