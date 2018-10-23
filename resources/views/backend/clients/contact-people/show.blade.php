@extends('backend.layouts.app')

@section('title', 'Clients | Show Contact Person')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Contact Person Management
                    <small class="text-muted">Show Contact Person</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>Name</th>
                                <td>{{$contact_person->initial->name}}.{{$contact_person->first_name}} {{$contact_person->middle_name}} {{$contact_person->last_name}}</td>
                            </tr>
                            <tr>
                                <th>Designation</th>
                                <td>{{$contact_person->designation->name}}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{$contact_person->email}}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{$contact_person->phone}}</td>
                            </tr>
                        </table>
                    </div>
            </div><!--col-->
            <div class="col-md-6">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th>Address Line 1</th>
                                <td>{{$contact_person->address_line_1}}</td>
                            </tr>
                            <tr>
                                <th>Address Line 2</th>
                                <td>{{$contact_person->address_line_2}}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{$contact_person->city}}</td>
                            </tr>
                            <tr>
                                <th>Postcode</th>
                                <td>{{$contact_person->postcode}}</td>
                            </tr>
                            <tr>
                                <th>County</th>
                                <td>{{$contact_person->county}}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{$contact_person->country->name}}</td>
                            </tr>
                        </table>
                    </div>
            </div><!--col-->
        </div><!--row-->
        <a href="{{route('admin.clients.show', ['id'=> $contact_person->client_id])}}" class="btn btn-danger">Back</a>
    </div><!--card-body-->
</div><!--card-->
@endsection
