@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>Edit Parking Space</h1>
        {!! Form::open(['action' => ['PSpotsController@update', $pspot->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <input type="hidden" id="place_id" name="place_id" value="{{$pspot->place_id}}" />
            <!input type="hidden" id="id" name="place_id" value="{{$pspot->place_id}}" />
            <div class="form-group">
                {{Form::label('location', 'Location')}}
                {{Form::text('location', $pspot->location, ['class' => 'form-control', 'placeholder' => 'Location'])}}
            </div>
            <div class="form-group">
                    {{Form::label('rent', 'Rent Fair (per hour)')}}
                    {{Form::text('rent', $pspot->rent_value, ['class' => 'form-control', 'placeholder' => 'Rent'])}}
            </div>
            <div class="form-group">
                {{Form::label('type', 'Vehicle Type')}}
                {{Form::text('type', $pspot->vehicle_type, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Vehicle Type'])}}
            </div>
            <div class="form-group">
                    {{Form::label('available', 'Availeble Places')}}
                    {{Form::text('available', $pspot->availability, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Available Places'])}}
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
</div>
@endsection