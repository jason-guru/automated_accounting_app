@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <h4 class="card-title mb-0">
                                Frequency Management <small class="text-muted">Set Frequency</small>
                            </h4>
                        </div><!--col-->
                    </div><!--row-->
                    <hr>
                    <div class="row">
                        <div class="col">
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
                        </div>
                    </div>
                    
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
