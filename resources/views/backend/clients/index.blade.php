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
                                            <th>Default Contact</th>
                                            <th>Contact Email</th>
                                            <th>Contact No</th>
                                            <th>Book Start</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--col-->
                        </div><!--row-->
                        <div class="row">
                            <div class="col-7">
                                {{-- <div class="float-left">
                                    {!! $users->total() !!} {{ trans_choice('labels.backend.access.users.table.total', $users->total()) }}
                                </div> --}}
                            </div><!--col-->
                
                            <div class="col-5">
                                {{-- <div class="float-right">
                                    {!! $users->render() !!}
                                </div> --}}
                            </div><!--col-->
                        </div><!--row-->
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
