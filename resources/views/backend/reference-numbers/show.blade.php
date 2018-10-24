@extends('backend.layouts.app')

@section('title',  'Deadlines | View Deadline')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-8">
                <h4 class="card-title mb-0">
                    Reference Numbers Management
                    <small class="text-muted">View Reference Number</small>
                </h4>
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4 mb-4">
            <div class="col">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#contact-person" role="tab" aria-controls="overview" aria-expanded="true"><i class="fas fa-book"></i> Details</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active show" id="contact-person" role="tabpanel" aria-expanded="true">
                        @include('backend.reference-numbers.show.tabs.details')
                    </div><!--tab-->
                </div><!--tab-content-->
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
