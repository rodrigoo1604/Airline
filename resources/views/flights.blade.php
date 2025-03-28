@extends('layouts.app')

@section('content')
<div class="flights-container">
    <h1>Available Flights</h1>
    @if($flights->isEmpty())
        <p>No flights available at the moment.</p>
    @else
        <div class="flights-list">
            @foreach($flights as $flight)
                <div class="flight-item">
                    <div class="flight-info">
                        <span class="flight-destination">{{ $flight->departure }} ✈ {{ $flight->arrival }}</span>
                        <span class="flight-date">{{ \Carbon\Carbon::parse($flight->date)->format('d M Y') }}</span>
                    </div>
                    <p><strong>Seats Available:</strong> {{ $flight->plane->seats }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
