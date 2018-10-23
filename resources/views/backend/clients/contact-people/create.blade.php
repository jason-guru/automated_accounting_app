@extends('backend.layouts.app')

@section('title', 'Clients | Create Contact Person')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">
            Create Contact Person
        </h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.contact-person.store')}}" method="POST">
        @csrf
        <div class="form-group">
                <label class="col-form-label">Designation:</label>
                <select name="designation_id" class="form-control">
                    @foreach($designations as $designation)
                      <option value="{{$designation->id}}">{{$designation->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <select name="initial_id" id="initial-id" class="form-control">
                          @foreach ($initials as $initial)
                              <option value="{{$initial->id}}">{{$initial->name}}</option>
                          @endforeach
                      </select>
                  </div>
                  <input type="text" class="form-control" name="first_name" placeholder="First Name" required value=" {{old('first_name')}}">
                  <input type="text" class="form-control" name="middle_name" placeholder="Middle Name" value=" {{old('middle_name')}}">
                  <input type="text" class="form-control" name="last_name" placeholder="Last Name" value=" {{old('last_name')}}">
              </div>
              <div class="row">
                  <div class="form-group col-md-6">
                  <label class="col-form-label">Email: <span class="text-danger">*</span></label>
                  <input type="email" name="email" class="form-control" required value="{{old('email')}}" placeholder="john@mail.com">
                  </div>
                  <div class="form-group col-md-6">
                      <label class="col-form-label">Phone: <span class="text-danger">*</span></label>
                      <input type="text" name="phone" class="form-control" required placeholder="+337008192123" value="{{old('phone')}}">
                      <small>Phone number with country code required</small>
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-6">
                      <label for="" class="col-form-label">Address Line 1</label>
                      <input type="text" class="form-control" name="address_line_1" value="{{old('address_line_1')}}">
                  </div>
                  <div class="form-group col-md-6">
                      <label for="" class="col-form-label">Address Line 2</label>
                      <input type="text" class="form-control" name="address_line_2" value="{{old('address_line_2')}}">
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-4">
                      <label for="" class="col-form-label">City</label>
                      <input type="text" class="form-control" name="city" value="{{old('city')}}">
                  </div>
                  <div class="form-group col-md-4">
                      <label for="" class="col-form-label">Postcode</label>
                      <input type="text" class="form-control" name="postcode" value="{{old('postcode')}}">
                  </div>
                  <div class="form-group col-md-4">
                      <label for="" class="col-form-label">County</label>
                      <input type="text" class="form-control" name="county" value="{{old('county')}}">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-form-label">Select Country</label>
                  <select name="country_id" id="" class="form-control">
                      @foreach ($countries as $country )
                          <option value="{{$country->id}}">{{$country->name}}</option>
                      @endforeach
                  </select>
              </div>
                <input type="hidden" name="client_id" value="{{$client_id}}">
        <a href="{{route('admin.clients.show', ['id'=> $client_id])}}" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-success pull-right">Save</button>
        </form>
    </div>
</div>
@endsection
