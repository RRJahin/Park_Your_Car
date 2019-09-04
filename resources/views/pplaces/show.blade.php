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
                        
                        <br><br><br><br>
                        <a href="/pspots/{{$pspot->id}}/edit" class="btn btn-default">Edit</a>
                        
                        {!!Form::open(['action' => ['PSpotsController@destroy', $pspot->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {!!Form::close()!!}
                            

                    </div>
                </div>
                @endforeach
            @else
                <p>No place found</p>
            @endif
    
                
            <a href="/pspots/create/{{$id}}" class="btn btn-default">Add Spot</a>
        </div>
    </div>
@endsection