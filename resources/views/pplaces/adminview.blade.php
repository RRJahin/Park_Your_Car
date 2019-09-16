@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>Parking Place Info</h2>
            <table class="table">
                <tbody>
                    <tr class="d-flex">
                    <th scope="row" style="width: 25%" > Place ID</th>
                    <td>{{$place_info->id}}</td>
                    </tr>

                    <tr class="d-flex">
                    <th scope="row" style="width: 25%" > Address</th>
                    <td>{{$place_info->address}}</td>
                    </tr>
                    
                    <tr class="d-flex">
                    <th scope="row" style="width: 25%" > Street</th>
                    <td>{{$place_info->format_address}}</td>
                    </tr>

                    <tr class="d-flex">
                    <th scope="row" style="width: 25%" > Owner </th>
                    <td>{{$owner_info->first_name.' '.$owner_info->last_name}}</td>
                    </tr>
                    
                    <tr class="d-flex">
                    <th scope="row" style="width: 25%" > Owner's NID </th>
                    <td>{{$owner_info->nid}}</td>
                    </tr>

                    <tr class="d-flex">
                    <th scope="row" style="width: 25%" > Phone </th>
                    <td>{{$owner_info->phone}}</td>
                    </tr>
                    
                    <tr class="d-flex">
                    <th scope="row" style="width: 25%" > Email </th>
                    <td>{{$owner_info->email}}</td>
                    </tr>

                </tbody>
            </table>

            <h2>Parking Spots</h2>
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
            <div class="well">
                <div class="row">
                    {!! Form::open(['action' => ['PPlacesController@update', $place_info->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <input type="hidden" id="place_id" name="place_id" value="{{$place_info->id}}" />
                        <input type="hidden" id="verify" name="verify" value="{{$admin_id}}" />
                        {{Form::hidden('_method','PUT')}}
                        {{Form::submit('Verify', ['class'=>'btn btn-primary'])}}
                    {!! Form::close() !!}

                    {!!Form::open(['action' => ['PPlacesController@destroy', $place_info->id], 'method' => 'POST', 'class' => 'pull-right'])!!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@endsection