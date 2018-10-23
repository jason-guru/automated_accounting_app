@extends('backend.layouts.app')

@section('title', 'Clients | Edit Client')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card" id="search-result">
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
                            <select name="company_type_id" id="company-type-id" class="form-control" disabled>
                                @foreach($company_types as $company_type)
                                    <option value="{{$company_type->id}}" {{$company_type->id == $client->company_type_id ? 'selected' : ''}}>{{$company_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Account Due Date <span class="text-danger">*</span></label>
                            <input data-toggle="datepicker" name="accounts_next_due" id="" class="form-control" value="{{Carbon\Carbon::parse($client->accounts_next_due)->format('d-m-Y')}}">
                        </div>
                        <div class="form-group">
                            <label for="accounts_overdue">Accounts Overdue <span class="text-danger">*</span></label>
                            <select name="accounts_overdue" id="accounts_overdue" class="form-control" required>
                                <option value="" disabled selected>Please Select</option>
                                <option value="1" {{$client->accounts_overdue == 1 ? "selected" : ""}}>Yes</option>
                                <option value="0" {{$client->accounts_overdue == 0 ? "selected" : ""}}>No</option>
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
        <div class="card">
            <div class="card-header">
                Business Info
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{$business_info->company_type_id == 6 ? "d-none" : ""}}">
                            <label for="">Business Start Date</label>
                            <input name="bussiness_start_date" id="" class="form-control" data-toggle="datepicker" value="{{$business_info->bussiness_start_date}}">
                        </div>
                        <div class="form-group {{$business_info->company_type_id == 6 ? "d-none" : ""}}">
                            <label for="">Book Start Date</label>
                            <input data-toggle="datepicker" name="book_start_date" id="" class="form-control" value="{{$business_info->book_start_date}}">
                        </div>
                        <div class="form-group {{$business_info->company_type_id == 6 ? "d-none" : ""}}">
                            <label for="">Year End Date</label>
                            <input data-toggle="datepicker" name="year_end_date" id="" class="form-control" value="{{$business_info->year_end_date}}">
                        </div>
                        <div class="form-group {{$business_info->company_type_id == 6 || $business_info->company_type_id == 2 || $business_info->company_type_id == 3 || $business_info->company_type_id == 4 || $business_info->company_type_id == 7 ? "d-none" : ""}}">
                        <label for="">Company Reg No.</label>
                            <input type="text" name="company_reg_number" id="" value="{{$business_info->company_reg_number}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">UTR Number</label>
                            <input type="text" name="utr_number" id="" class="form-control" value="{{$business_info->utr_number}}">
                        </div>
                        <div class="form-group">
                            <label for="">UTR</label>
                            <input type="text" name="utr" id="" class="form-control" value="{{$business_info->utr}}">
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {{$business_info->company_type_id == 6 ? "d-none" : ""}}">
                            <label for="">Vat Submit Type</label>
                            <select name="vat_submit_type_id" id="" class="form-control">
                                @foreach ($vat_submit_types as $vat_submit_type )
                                    <option value="{{$vat_submit_type->id}}" {{$business_info->vat_submit_type_id == $vat_submit_type->id ? "selected" : ""}}>{{$vat_submit_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group {{$business_info->company_type_id == 6 ? "d-none" : ""}}">
                            <label for="">VAT Registration Number</label>
                            <input type="text" name="vat_reg_number" id="" class="form-control" value="{{$business_info->vat_reg_number}}">
                        </div>
                        <div class="form-group {{$business_info->company_type_id == 6 ? "d-none" : ""}}">
                            <label for="">VAT Registration Date</label>
                            <input data-toggle="datepicker" name="vat_reg_date" id="" class="form-control" value="{{$business_info->vat_reg_date}}">
                        </div>
                        <div class="form-group">
                            <label for="">Social Media</label>
                            <input type="text" name="social_media" id="" class="form-control" value="{{$business_info->social_media}}">
                        </div>
                        <div class="form-group">
                            <label for="">Last Bookkeeping Done</label>
                        <input data-toggle="datepicker" name="last_bookkeeping_done" id="" class="form-control" value="{{$business_info->last_bookkeeping_done}}">
                        </div>
                        <div class="form-group {{$business_info->company_type_id == 6 ? "d-none" : ""}}">
                            <label for="">Vat Scheme</label> 
                            <select name="vat_scheme_id" id="" class="form-control">
                                @foreach ($vat_schemes as $vat_scheme)
                                    <option value="{{$vat_scheme->id}}" {{$business_info->vat_scheme_id == $vat_scheme->id?"selected": ""}}>{{$vat_scheme->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Place the Business Info section here --}}

        <a href="{{route('admin.clients.index')}}" class="btn btn-danger">Back</a>
        <button type="submit" class="btn btn-success pull-right">Update</button>
        </form>
    </div>
</div>
<script>
    var companyNumber =  {{ !is_null($client->company_number) ? $client->company_number : null }};
</script>
@endsection
