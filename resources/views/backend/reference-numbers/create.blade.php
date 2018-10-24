@extends('backend.layouts.app')

@section('title', 'Reference Number | Reference Number')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Create New Reference Number
            </div><!--col-->
        </div><!--row-->
        <hr>
        <form action="{{route('admin.reference-numbers.store')}}" method="post" enctype='multipart/form-data'>
            @csrf
                <div class="form-group mt-4">
                    <label for="name" class="col-form-label">Name: <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="client-id"  class="col-form-label">Select Client <span class="text-danger">*</span></label>
                    <select name="client_id" id="client-id" class="form-control">
                        @foreach ($clients as $client)
                            <option value="{{$client->id}}">{{$client->company_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="reference-number">Reference Number</label>
                    <input type="text" name="reference_number" id="reference-number" class="form-control">
                </div> 
                <label for="amount">Amount</label>
                    <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">£</span>
                    </div>
                    <input type="text" name="amount" class="form-control" id="amount" aria-describedby="basic-addon3">
                </div>
                <div class="form-group">
                    <label for="invoice">Upload Invoice</label>
                    <input type="file" id="invoice" name="invoice" class="form-control">
                </div>  
                <div class="form-group"><button type="submit" class="btn btn-success pull-right">Save</button></div>
        </form>
    </div><!--card-body-->
    </div><!--card-->
@endsection
