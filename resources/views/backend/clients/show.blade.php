@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.view'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Client Management
                    <small class="text-muted">View Client</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#contact-person" role="tab" aria-controls="overview" aria-expanded="true"><i class="fas fa-user"></i> Contact People</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#basic-info" role="tab" aria-controls="overview" aria-expanded="true"><i class="fas fa-info"></i> Basic Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#address" role="tab" aria-controls="overview" aria-expanded="true"><i class="fas fa-address-book"></i> Address</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#contact-info" role="tab" aria-controls="overview" aria-expanded="true"><i class="fas fa-building"></i> Company Contact Info</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active show" id="contact-person" role="tabpanel" aria-expanded="true">
                        @include('backend.clients.show.tabs.contact-person')
                    </div><!--tab-->
                    <div class="tab-pane" id="basic-info" role="tabpanel" aria-expanded="true">
                        @include('backend.clients.show.tabs.basic-info')
                    </div><!--tab-->
                    <div class="tab-pane" id="address" role="tabpanel" aria-expanded="true">
                        @include('backend.clients.show.tabs.address')
                    </div><!--tab-->
                    <div class="tab-pane" id="contact-info" role="tabpanel" aria-expanded="true">
                        @include('backend.clients.show.tabs.contact')
                    </div><!--tab-->
                </div><!--tab-content-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->

    {{-- <div class="card-footer">
        <div class="row">
            <div class="col">
                <small class="float-right text-muted">
                    <strong>@lang('labels.backend.access.users.tabs.content.overview.created_at'):</strong> {{ timezone()->convertToLocal($user->created_at) }} ({{ $user->created_at->diffForHumans() }}),
                    <strong>@lang('labels.backend.access.users.tabs.content.overview.last_updated'):</strong> {{ timezone()->convertToLocal($user->updated_at) }} ({{ $user->updated_at->diffForHumans() }})
                    @if($user->trashed())
                        <strong>@lang('labels.backend.access.users.tabs.content.overview.deleted_at'):</strong> {{ timezone()->convertToLocal($user->deleted_at) }} ({{ $user->deleted_at->diffForHumans() }})
                    @endif
                </small>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-footer--> --}}
</div><!--card-->
@endsection
