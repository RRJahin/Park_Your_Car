@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Parking Spots</h1>
            @if(count($pspots) > 0)
                @foreach($pspots as $pspot)
                <div class="well">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <h3>{{'Vehicle Type: '.$pspot->vehicle_type}}</h3>
                            {{'Location: '.$pspot->location}}
                            <br>{{'Rent: '.$pspot->rent_value}}
                            <br>{{'Available: '.$pspot->availability}}
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p>No place found</p>
            @endif
        </div>
    </div>
@endsection