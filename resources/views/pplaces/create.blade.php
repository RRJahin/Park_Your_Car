@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Add Place</h1>
            {!! Form::open(['action' => 'PPlacesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                {{Form::label('address', 'Address')}}
                {{Form::textarea('address', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Address'])}}
            </div>
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection