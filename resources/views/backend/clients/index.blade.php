@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                        <div class="row">
                            <div class="col-sm-5">
                                <h4 class="card-title mb-0">
                                    @lang('strings.backend.clients.title') <small class="text-muted">Active Clients</small>
                                </h4>
                            </div><!--col-->
                            <div class="col-sm-7">
                                @include('backend.clients.includes.header-buttons')
                            </div><!--col-->
                        </div><!--row-->
                </div><!--card-header-->
                <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Client ID</th>
                                            <th>Client Name</th>
                                            <th>Client Type</th>
                                            <th>Contact Email</th>
                                            <th>Contact No</th>
                                            <th>Next Due</th>
                                            <th>Reminder</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($clients as $client)
                                            <tr>
                                                <td>{{$client->company_number}}</td>
                                                <td>{{$client->company_name}}</td>
                                                <td>{{$client->company_type->name}}</td>
                                                <td>{{$client->email}}</td>
                                                <td>{{$client->phone}}</td>
                                                <td>{{$client->accounts_next_due}}</td>
                                                <td>
                                                    <label class="switch switch-label switch-pill switch-success mr-2" for="to-remind-{{$client->id}}">
                                                    <input class="switch-input" data-id="{{$client->id}}" type="checkbox" name="remind[]" id="to-remind-{{$client->id}}" value="{{$client->remind}}" {{$client->remind == 1 ? "checked" : ""}} data-url="{{route('admin.clients.update', ['id' => $client->id])}}">
                                                        <span class="switch-slider" data-checked="on" data-unchecked="off"></span>
                                                    </label>
                                                </td>
                                                <td>{!!$client->action_buttons!!}</td>
                                            </tr> 
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col-7">
                                <div class="float-left">
                                    {!! $clients->total() !!} {{ trans_choice('total client(s)', $clients->total()) }}
                                </div>
                            </div><!--col-->
                
                            <div class="col-5">
                                <div class="float-right">
                                    {!! $clients->render() !!}
                                </div>
                            </div><!--col-->
                        </div><!--row-->
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
