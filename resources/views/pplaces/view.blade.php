@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>Parking Place Info</h2>
            <table class="table">
                <tbody>
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
                    <th scope="row" style="width: 25%" > Booking Phone Number </th>
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

            <h2>User Review</h2>
            @if(count($reviews) > 0)
                @foreach($reviews as $review)
                <div class="well">
                    <div class="row">
                        <div class="col-md-8 col-sm-8">
                            <h4>{{$review->comment}}</h4>
                            <small>{{'     '.$review->first_name.' '.$review->last_name}}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <p>No Comments Found</p>
            @endif

            <div class="col-md-8 col-md-offset-2">
                <h2>Add Comment</h2>
                {!! Form::open(['id' => 'commentForm','name' => 'commentForm', 'action' => 'PPlacesController@storeComment', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <input type="hidden" id="place_id" name="place_id" value="{{$id}}" />
                <input type="hidden" id="type" name="type" value="{{$type}}" />
                <div class="form-group">
                    {{Form::label('comment', 'Comment')}}
                    {{Form::textArea('comment', '', ['class' => 'form-control', 'placeholder' => 'Your Comment'])}}
                </div>
                {{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
                {!! Form::close() !!}
            </div>

            
        </div>

    </div>
@endsection