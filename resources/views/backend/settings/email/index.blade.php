@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>Email Configurations</strong>
                </div><!--card-header-->
                <div class="card-body">
                <form action="{{route('admin.email-config.update')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Mail Driver</label>
                        <select name="mail_driver" id="mail-driver" class="form-control">
                            @foreach ($mail_drivers as $key => $mail_driver )
                            <option value="{{$key}}" {{config('mail.driver') == $key? "selected" : ""}}>{{$mail_driver}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Mail Host</label>
                    <input type="text" name="mail_host" id="mail-host" class="form-control" value="{{config('mail.host')}}"></div>

                    <div class="form-group">
                        <label for="">Mail Port</label>
                    <input type="text" name="mail_port" id="mail-port" class="form-control" value="{{config('mail.port')}}"></div>

                    <div class="form-group">
                        <label for="">Mail From Address</label>
                    <input type="text" name="mail_from_address" id="mail-from-address" class="form-control" value="{{config('mail.from.address')}}">
                    </div>

                    <div class="form-group">
                            <label for="">Mail From Name</label>
                        <input type="text" name="mail_from_name" id="mail-from-name" class="form-control" value="{{config('mail.from.name')}}">
                    </div>

                    <div class="form-group">
                            <label for="">Mail Encryption</label>
                        <input type="text" name="mail_encryption" id="mail-encryption" class="form-control" value="{{config('mail.encryption')}}">
                    </div>

                    <div class="form-group">
                            <label for="">Mail Username</label>
                        <input type="text" name="mail_username" id="mail-username" class="form-control" value="{{config('mail.username')}}">
                    </div>

                    <div class="form-group">
                            <label for="">Mail Password</label>
                        <input type="text" name="mail_password" id="mail-password" class="form-control" value="{{config('mail.password')}}">
                    </div>
                    <button class="btn btn-success float-right">Submit</button>
                </form>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
