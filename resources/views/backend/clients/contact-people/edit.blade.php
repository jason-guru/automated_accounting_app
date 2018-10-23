@extends('backend.layouts.app')

@section('title', 'Clients | Edit Contact Person')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">
            Edit Contact Person
        </h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.contact-person.update', ['id'=> $contact_person->id])}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
                <label class="col-form-label">Designation:</label>
                <select name="designation_id" class="form-control">
                    @foreach($designations as $designation)
                      <option value="{{$designation->id}}" {{$designation->id == $contact_person->designation_id? 'selected': ''}}>{{$designation->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="input-group">
                  <div class="input-group-prepend">
                      <select name="initial_id" id="initial-id" class="form-control">
                          @foreach ($initials as $initial)
                              <option value="{{$initial->id}}" {{$initial->id == $contact_person->initial_id? 'selected': ''}}>{{$initial->name}}</option>
                          @endforeach
                      </select>
                  </div>
                <input type="text" class="form-control" name="first_name" placeholder="First Name" required value="{{$contact_person->first_name}}">
                  <input type="text" class="form-control" name="middle_name" placeholder="Middle Name" value="{{$contact_person->middle_name}}">
                  <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{$contact_person->last_name}}">
              </div>
              <div class="row">
                  <div class="form-group col-md-6">
                  <label class="col-form-label">Email:</label>
                  <input type="email" name="email" class="form-control" required value="{{$contact_person->email}}">
                  </div>
                  <div class="form-group col-md-6">
                      <label class="col-form-label">Phone:</label>
                      <input type="text" name="phone" class="form-control" required value="{{$contact_person->phone}}" placeholder="+337008192123">
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-6">
                      <label for="" class="col-form-label">Address Line 1</label>
                      <input type="text" class="form-control" name="address_line_1" value="{{$contact_person->address_line_1}}">
                  </div>
                  <div class="form-group col-md-6">
                      <label for="" class="col-form-label">Address Line 2</label>
                      <input type="text" class="form-control" name="address_line_2" value="{{$contact_person->address_line_2}}">
                  </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-4">
                      <label for="" class="col-form-label">City</label>
                      <input type="text" class="form-control" name="city" value="{{$contact_person->city}}">
                  </div>
                  <div class="form-group col-md-4">
                      <label for="" class="col-form-label">Postcode</label>
                      <input type="text" class="form-control" name="postcode" value="{{$contact_person->postcode}}">
                  </div>
                  <div class="form-group col-md-4">
                      <label for="" class="col-form-label">County</label>
                      <input type="text" class="form-control" name="county" value="{{$contact_person->county}}">
                  </div>
              </div>
              <div class="form-group">
                  <label for="" class="col-form-label">Select Country</label>
                  <select name="country_id" id="" class="form-control">
                      @foreach ($countries as $country )
                          <option value="{{$country->id}}" {{$country->id == $contact_person->country_id? 'selected': ''}} >{{$country->name}}</option>
                      @endforeach
                  </select>
              </div>
              <input type="hidden" name="client_id" value="{{$contact_person->client_id}}">
            <a href="{{route('admin.clients.show', ['id'=> $contact_person->client_id])}}" class="btn btn-danger">Back</a>
            <button type="submit" class="btn btn-success pull-right">Update</button>
        </form>
    </div>
</div>
@endsection
