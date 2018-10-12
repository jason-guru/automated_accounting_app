<div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pb-2">
                    @include('backend.clients.contact-people.includes.header-buttons')
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Contact Name</th>
                            <th>Designation</th>
                            <th>Contact Email</th>
                            <th>Contact Number</th>
                            <th>Country</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($client->contact_people as $contact_person)
                            <tr>
                                <td>{{$contact_person->first_name}} {{$contact_person->middle_name}} {{$contact_person->last_name}}</td>
                                <td>{{$contact_person->designation->name}}</td>
                                <td>{{$contact_person->email}}</td>
                                <td>{{$contact_person->phone}}</td>
                                <td>{{$contact_person->country->name}}</td>
                                <td>{!!$contact_person->action_buttons!!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div>
    </div>