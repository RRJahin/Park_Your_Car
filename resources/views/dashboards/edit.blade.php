@extends('layouts.app')


@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1>Edit Profile</h1>
        {!! Form::open(['action' => ['HomeController@updateProfile', $profile->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
  
            <div class="form-group">
                {{Form::label('first_name', 'First Name')}}
                {{Form::text('first_name', $profile->first_name, ['class' => 'form-control', 'placeholder' => 'First Name'])}}
            </div>
            <div class="form-group">
                    {{Form::label('last_name', 'Last Name')}}
                    {{Form::text('last_name', $profile->last_name, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Last Name'])}}
            </div>
            <div class="form-group">
                    {{Form::label('phone', 'Phone No.')}}
                    {{Form::text('phone', $profile->phone, ['class' => 'form-control', 'placeholder' => 'Phone No'])}}
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
</div>
@endsection