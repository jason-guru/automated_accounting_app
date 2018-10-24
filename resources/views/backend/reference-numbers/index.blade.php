@extends('backend.layouts.app')

@section('title', 'Reference Number | Active Reference Number')

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-7">
                <h4 class="card-title mb-0">
                    Reference Number Management <small class="text-muted">Active Reference Number</small>
                </h4>
            </div><!--col-->
            <div class="col-sm-5">
                @include('backend.reference-numbers.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Reference Number</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($reference_numbers as $reference_number)
                                <tr>
                                    <td>{{$reference_number->client->company_name}}</td>
                                    <td>{{$reference_number->reference_number}}</td>
                                    <td>£{{number_format($reference_number->amount, 2)}}</td>
                                    <td>{!!$reference_number->action_buttons!!}</td>
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
                    {!! $reference_numbers->count() !!} {{ trans_choice('total reference number(s)', $reference_numbers->count()) }}
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $reference_numbers->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
