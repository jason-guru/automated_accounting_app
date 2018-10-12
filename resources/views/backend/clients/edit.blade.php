@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">
            Client Management
            <small class="text-muted">Edit Client</small>
        </h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.clients.update', ['id' => $client->id])}}" method="post">
        @method('PUT')
        @csrf
        <div class="card">
            <div class="card-header">
                <strong>Basic Info</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company-number">Client ID</label>
                            <input name="company_number" id="company-number" type="text" class="form-control" value="{{$client->company_number}}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="company-type-id">Client Type</label>
                            <select name="company_type_id" id="company-type-id" class="form-control">
                                @foreach($company_types as $company_type)
                                    <option value="{{$company_type->id}}" {{$company_type->code == $client->company_type->code ? 'selected' : ''}}>{{$company_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company-name">Company Name</label>
                            <input name="company_name" id="company-name" type="text" class="form-control" value="{{$client->company_name}}" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>{{-- End of Basic info header --}}

        <div class="card">
            <div class="card-header">
                <strong>Address</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address-line-1">Address Line 1</label>
                            <input name="address_line_1" id="address-line-1" type="text" class="form-control" value="{{$client->address_line_1}}">
                        </div>
                        <div class="form-group">
                            <label for="address-line-2">Address Line 2</label>
                            <input name="address_line_2" id="address-line-2" type="text" class="form-control" value="{{$client->address_line_2}}">
                        </div>
                        <div class="form-group">
                            <label for="city">City/Town/Locality</label>
                            <input name="city" type="text" id="city" class="form-control" value="{{$client->city}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postcode">Post Code</label>
                            <input name="postcode" id="postcode" type="text" class="form-control" value="{{$client->postcode}}">
                        </div>
                        <div class="form-group">
                            <label for="county">County</label>
                            <input name="county" id="county" type="text" class="form-control" value="{{$client->county}}">
                        </div>
                        <div class="form-group">
                            <label for="country-id">Country</label>
                            <select name="country_id" id="country-id" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" {{$country->name == $client->country->name ? 'selected' : ''}}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>{{-- End of contact info header --}}

        <div class="card">
            <div class="card-header">
                <strong>Contact Info</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input name="phone" id="phone" type="text" placeholder="+44760092100" class="form-control" value="{{$client->phone}}" required maxlength="13">
                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input name="website" id="website" type="text" class="form-control" value="{{$client->website}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" id="email" type="email" class="form-control" value="{{$client->email}}" required placeholder="john@mail.com">
                        </div>
                    </div>
                </div>
            </div>
        </div>{{-- End of Contact info header --}}
        {{-- Place the Business Info section here --}}
        <a href="{{route('admin.clients.index')}}" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-success pull-right">Update</button>
        </form>
    </div>
</div>
   
@endsection
