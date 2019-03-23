@extends('backend.layouts.app')

@section('title', 'Clients | Deadlines')

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">
                                @lang('strings.backend.clients.title')  
                                Deadlines
                            </h4>
                        </div><!--col-->
                        {{-- <div class="col-sm-7">
                            @include('backend.clients.includes.header-buttons')
                        </div><!--col--> --}}
                    </div><!--row-->
            </div><!--card-header-->
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <client-deadline :clients="{{$clients}}" 
                        :vat-frequencies="{{json_encode(config('dropdowns.deadline_type.VAT.filing.frequency'), true)}}"
                        ></client-deadline>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection