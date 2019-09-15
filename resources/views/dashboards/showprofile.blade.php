@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h1>Profile</h1>
            @if(count($userinfo) > 0)
            @foreach($userinfo as $info)
            <div class="well">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h1> {{$info->first_name}} </h1>
                        <h1> {{$info->last_name}} </h1>
                            <h1> {{$info->email}} </h1>
                            <h1> {{$info->nid}} </h1>
                             <h1> {{$info->phone}} </h1>
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
