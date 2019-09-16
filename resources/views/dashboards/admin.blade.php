@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h2>Parking Places to Varify</h2>
            @if(count($pplaces) > 0)
            @foreach($pplaces as $pplace)
            <div class="well">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3> 
                            <a href="/admin/viewpplaces/{{$pplace->id}}"> 
                                {{'Place ID: '.$pplace->id}} 
                            </a> 
                        </h3>
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
