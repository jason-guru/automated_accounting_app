@extends('backend.layouts.app')

@section('title', 'Deadlines | Edit Deadline')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Edit Deadline
            </div><!--col-->
        </div><!--row-->
        <hr>
        <form action="{{route('admin.deadlines.update', ['id' => $deadline->id])}}" method="post">
            @method('PUT')
            @csrf
                <div class="form-group mt-4">
                    <label for="" class=" col-form-label">Name: <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="" class="form-control" value="{{$deadline->name}}">
                </div>
                <div class="form-group">
                    <label for=""  class="col-form-label">Message Format <span class="text-danger">*</span></label>
                    <select name="message_format_id" id="" class="form-control">
                        @foreach ($message_formats as $message_format)
                            <option value="{{$message_format->id}}" {{$deadline->message_format_id == $message_format->id ? "selected" : ""}}>{{$message_format->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group"><button type="submit" class="btn btn-success pull-right">Save</button></div>
        </form>
    </div><!--card-body-->
    </div><!--card-->
@endsection
