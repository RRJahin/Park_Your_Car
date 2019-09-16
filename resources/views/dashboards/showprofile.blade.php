@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h2>Owner Profile Info</h2>
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
        </div>
    </div>
</div>
@endsection
