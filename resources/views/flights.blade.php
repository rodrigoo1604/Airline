@extends('layouts.app')

@section('content')
<div class="flights-container">
    <h1>Available Flights</h1>
    @if($flights->isEmpty())
        <p>No flights available at the moment.</p>
    @else
        <table class="flights-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Departure</th>
                    <th>Arrival</th>
                    <th>Seats</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($flights as $flight)
                    <tr>
                        <td>{{ $flight->date }}</td>
                        <td>{{ $flight->departure }}</td>
                        <td>{{ $flight->arrival }}</td>
                        <td>{{ $flight->plane->seats }}</td>
                        <td>
                            <a href="#" class="btn">Book Now</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
