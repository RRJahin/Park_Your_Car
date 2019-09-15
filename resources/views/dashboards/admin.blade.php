@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h1>Parking Places</h1>
            @if(count($pplaces) > 0)
            @foreach($pplaces as $pplace)
            <div class="well">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3> {{$pplace->address}} </h3>
                        <h2> {{$pplace->id}} </h2>

                        {!! Form::open(['action' => ['PPlacesController@update', $pplace->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" id="place_id" name="place_id" value="{{$pplace->id}}" />
                        <input type="hidden" id="verify" name="verify" value="{{$id}}" />

                            {{Form::hidden('_method','PUT')}}

                            <a href="/home/showprofile/{{$pplace->owner_id}}" class="btn btn-primary">View Profile</a>
                            {{Form::submit('Verify', ['class'=>'btn btn-primary'])}}
                        {!! Form::close() !!}

                    </div>

                </div>

            </div>
            @endforeach
            @else
            <p>No place found</p>
            @endif

        </div>
    </div>
</div>
@endsection
