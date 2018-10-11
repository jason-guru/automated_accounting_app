@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card level-card level-all">
                            <div class="card-header bg-info">
                                <span class="level-icon"> Clients</span> 
                            </div>
                            <div class="card-body">
                                <b>{!! $clients->count() !!} {{ trans_choice('total client', $clients->count()) }}
                                </b>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card level-card level-all">
                            <div class="card-header bg-success">
                                <span class="level-icon"> Active Reminders</span> 
                            </div>
                            <div class="card-body">
                                <b>{!! $reminders->count() !!} {{ trans_choice('total active reminder', $reminders->count()) }}
                                </b>
                            </div>
                        </div>
                    </div>
                </div>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
