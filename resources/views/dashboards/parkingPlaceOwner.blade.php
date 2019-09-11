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
                        <h3><a href="/pplaces/{{$pplace->id}}">{{$pplace->address}}</a></h3>
                        @foreach ($temp as $item)
                        @if ($item->id == $pplace->owner_id)
                        {{$item->first_name." ".$item->last_name}}

                        {!!Form::open(['action' => ['PPlacesController@destroy', $pplace->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                        {!!Form::close()!!}
                        
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <p>No place found</p>
            @endif

            <a href="/pplaces/create" class="btn btn-default">Add Place</a>
        </div>
    </div>
</div>
@endsection