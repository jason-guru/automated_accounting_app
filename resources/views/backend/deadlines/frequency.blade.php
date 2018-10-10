@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                <strong>{{__('strings.backend.deadlines.reminders.title')}} @lang('strings.backend.deadlines.frequency.title')</strong>
                </div><!--card-header-->
                <div class="card-body">
                    <form action="{{route('admin.deadlines.frequency.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="frequency">Select Frequency</label>
                            <select name="frequency_id" id="frequency" class="form-control">
                                @foreach ($frequencies as $frequency)
                                    <option value="{{$frequency->id}}" {{$frequency->is_active == 1? "selected" : ""}}>{{$frequency->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success pull-right">Save</button>
                    </form>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
