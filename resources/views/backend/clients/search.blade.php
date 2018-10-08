@extends('backend.layouts.app')

@section('title', __('labels.backend.access.users.management') . ' | ' . __('labels.backend.access.users.create'))

@section('breadcrumb-links')
    @include('backend.auth.user.includes.breadcrumb-links')
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">
            Search Client
        </h4>
    </div>
    <div class="card-body">
         {{-- The company id search form --}}
        <form action="{{route('admin.client.search.result')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Enter Client Id</label>
                <input type="text" class="form-control" name="client_id">
            </div>
            <button type="submit" class="btn btn-success btn-sm">Search</button>
        </form>
    </div>
</div>
   
@endsection
