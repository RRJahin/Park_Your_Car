@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>Add Space</h1>
        {!! Form::open(['action' => 'PSpotsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            <input type="hidden" id="place_id" name="place_id" value="{{$id}}" />
            {{Form::label('location', 'Location')}}
            {{Form::text('location', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Location'])}}
            
            {{Form::label('rent_value', 'Rent Fair (per hour)')}}
            {{Form::text('rent_value', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Rent Fair (per hour)'])}}
            
            {{Form::label('vehicle_type', 'Vehicle Type')}}
            {{Form::text('vehicle_type', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Vehicle Type'])}}
            
            {{Form::label('available', 'Availeble Places')}}
            {{Form::text('available', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Availeble Places'])}}
            
        </div>
        {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
</div>
@endsection