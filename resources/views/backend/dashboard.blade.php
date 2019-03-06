@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row" id="v-dashboard">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <filter-component :values="{{json_encode(config('filter.value'), true)}}"></filter-component>
                        </div>
                    </div>
                    <div class="row">
                    
                    <div class="col-md-4 col-sm-6 mb-3">
                        <bar-chart-container :url="'{{url('api/deadline/aa-cs')}}'" ></bar-chart-container>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <bar-chart-container :url="'{{url('api/deadline/vat')}}'" ></bar-chart-container>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-3">
                        <bar-chart-container :url="'{{url('api/deadline/paye-cis')}}'"></bar-chart-container>
                    </div>
                </div>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
