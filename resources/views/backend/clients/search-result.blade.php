@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card" id="search-result">
    <div class="card-header">
        <h4 class="card-title mb-0">
            Details
        </h4>
    </div>
    <div class="card-body">
        <form action="{{route('admin.clients.store')}}" method="POST">
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
                            <input name="company_number" id="company-number" type="text" class="form-control" value="{{$client_data['company_number']}}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="company-type-id">Client Type</label>
                            <select name="company_type_id" id="company-type-id" class="form-control" @change="companyTypeChanged">
                                @foreach($company_types as $company_type)
                                    <option value="{{$company_type->id}}" {{array_key_exists('type', $client_data) ? $company_type->code == $client_data['type'] ? 'selected' : '' : ''}}>{{$company_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company-name">Company Name</label>
                            <input name="company_name" id="company-name" type="text" class="form-control" value="{{array_key_exists('company_name', $client_data ) ? $client_data['company_name'] : ''}}" readonly>
                            <input type="hidden" name="accounts_next_due" value="{{array_key_exists('next_due', $client_data['accounts']) ? $client_data['accounts']['next_due'] : ''}}">
                            <input type="hidden" name="accounts_overdue" value="{{array_key_exists('overdue',$client_data['accounts']) ? $client_data['accounts']['overdue'] == false ? 0 : 1 : ''}}">
                        </div>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#contactModal"><i class="fa fa-plus-circle"></i> Add Contact Person</a>
                        <div class="table-responsive mt-2">
                            <table id="contact-person-listing" class="table table-hover">
                                <thead>
                                <tr>
                                    <th>FirstName</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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
                            <input name="address_line_1" id="address-line-1" type="text" class="form-control" value="{{ array_key_exists('address_line_1', $client_data['registered_office_address']) ? $client_data['registered_office_address']['address_line_1'] : ''}}">
                        </div>
                        <div class="form-group">
                            <label for="address-line-2">Address Line 2</label>
                            <input name="address_line_2" id="address-line-2" type="text" class="form-control" value="{{ array_key_exists('address_line_2', $client_data['registered_office_address']) ? $client_data['registered_office_address']['address_line_2'] : ''}}">
                        </div>
                        <div class="form-group">
                            <label for="city">City/Town/Locality</label>
                            <input name="city" type="text" id="city" class="form-control" value="{{ array_key_exists('locality', $client_data['registered_office_address']) ? $client_data['registered_office_address']['locality'] : ''}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="postcode">Post Code</label>
                            <input name="postcode" id="postcode" type="text" class="form-control" value="{{ array_key_exists('postal_code', $client_data['registered_office_address']) ? $client_data['registered_office_address']['postal_code'] : ''}}">
                        </div>
                        <div class="form-group">
                            <label for="county">County</label>
                            <input name="county" id="county" type="text" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="country-id">Country</label>
                            <select name="country_id" id="country-id" class="form-control">
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}" 
                                        {{ array_key_exists("country",$client_data['registered_office_address']) ? $country->name == $client_data['registered_office_address']['country'] ? 'selected' : '' : '' }}
                                        >{{$country->name}}</option>
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
                            <input name="phone" id="phone" type="text" placeholder="+44760092100" class="form-control" value="" required maxlength="13">
                        </div>

                        <div class="form-group">
                            <label for="website">Website</label>
                            <input name="website" id="website" type="text" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" id="email" type="email" class="form-control" value="" required placeholder="john@mail.com">
                        </div>
                    </div>
                </div>
            </div>
        </div>{{-- End of Contact info header --}}
        {{-- Place the Business Info section here --}}
        <div class="card">
            <div class="card-header">
                Business Info
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" :class="noDisplayforIndividual">
                            <label for="">Business Start Date</label>
                            <input name="bussiness_start_date" id="" class="form-control" data-toggle="datepicker" value="{{array_key_exists('date_of_creation', $client_data) ? Carbon\Carbon::parse($client_data['date_of_creation'])->format('d-m-Y') : ''}}">
                        </div>
                        <div class="form-group" :class="noDisplayforIndividual">
                            <label for="">Book Start Date</label>
                            <input data-toggle="datepicker" name="book_start_date" id="" class="form-control" value="{{array_key_exists('period_start_on', $client_data['accounts']['next_accounts']) ? Carbon\Carbon::parse($client_data['accounts']['next_accounts']['period_start_on'])->format('d-m-Y') : ''}}">
                        </div>
                        <div class="form-group" :class="noDisplayforIndividual">
                            <label for="">Year End Date</label>
                            <input data-toggle="datepicker" name="year_end_date" id="" class="form-control" value="{{array_key_exists('period_end_on', $client_data['accounts']['next_accounts']) ? Carbon\Carbon::parse($client_data['accounts']['next_accounts']['period_end_on'])->format('d-m-Y') : ''}}">
                        </div>
                        <div class="form-group" :class="noCompanyNumberDisplay">
                        <label for="">Company Reg No.</label>
                            <input type="text" name="company_reg_number" id="" class="form-control" v-model="companyNumber">
                        </div>
                        <div class="form-group">
                            <label for="">UTR Number</label>
                            <input type="text" name="utr_number" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">UTR</label>
                            <input type="text" name="utr" id="" class="form-control">
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="noDisplayforIndividual">
                            <label for="">Vat Submit Type</label>
                            <select name="vat_submit_type_id" id="" class="form-control">
                                @foreach ($vat_submit_types as $vat_submit_type )
                                    <option value="{{$vat_submit_type->id}}">{{$vat_submit_type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" :class="noDisplayforIndividual">
                            <label for="">VAT Registration Number</label>
                            <input type="text" name="vat_reg_number" id="" class="form-control">
                        </div>
                        <div class="form-group" :class="noDisplayforIndividual">
                            <label for="">VAT Registration Date</label>
                            <input data-toggle="datepicker" name="vat_reg_date" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Social Media</label>
                            <input type="text" name="social_media" id="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Last Bookkeeping Done</label>
                            <input data-toggle="datepicker" name="last_bookkeeping_done" id="" class="form-control" value="{{array_key_exists('made_up_to', $client_data['accounts']['last_accounts']) ? Carbon\Carbon::parse($client_data['accounts']['last_accounts']['made_up_to'])->format('d-m-Y') : ''}}">
                        </div>
                        <div class="form-group" :class="noDisplayforIndividual">
                            <label for="">Vat Scheme</label> 
                            <select name="vat_scheme_id" id="" class="form-control">
                                @foreach ($vat_schemes as $vat_scheme )
                                    <option value="{{$vat_scheme->id}}">{{$vat_scheme->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success pull-right">Save</button>
        </form>
    </div>
</div>

<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <form action="{{route('admin.client.search.contact_person')}}" id="contact-modal-form">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="contactModalLabel">Add Contact Person</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
                <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                <input type="text" class="form-control" name="middle_name" placeholder="Middle Name">
                <input type="text" class="form-control" name="last_name" placeholder="Last Name">
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                <label class="col-form-label">Email:</label>
                <input type="email" name="contact_email" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label class="col-form-label">Phone:</label>
                    <input type="text" name="contact_phone" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="" class="col-form-label">Address Line 1</label>
                    <input type="text" class="form-control" name="contact_address_line_1">
                </div>
                <div class="form-group col-md-6">
                    <label for="" class="col-form-label">Address Line 2</label>
                    <input type="text" class="form-control" name="contact_address_line_2">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="" class="col-form-label">City</label>
                    <input type="text" class="form-control" name="contact_city">
                </div>
                <div class="form-group col-md-4">
                    <label for="" class="col-form-label">Postcode</label>
                    <input type="text" class="form-control" name="contact_postcode">
                </div>
                <div class="form-group col-md-4">
                    <label for="" class="col-form-label">County</label>
                    <input type="text" class="form-control" name="contact_county">
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-form-label">Select Country</label>
                <select name="contact_country_id" id="" class="form-control">
                    @foreach ($countries as $country )
                        <option value="{{$country->id}}">{{$country->name}}</option>
                    @endforeach
                </select>
            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="add-contact-person">Add Person</button>
        </div>
      </div>
    </form>
    </div>
  </div>
<script>
    var companyNumber =  {{ $client_data['company_number'] }};
</script>
@endsection
