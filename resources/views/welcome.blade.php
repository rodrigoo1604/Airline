@extends('layouts.app')

@section('content')
<div class="welcome-container">
    <h1>Welcome</h1>
    <p>Your journey starts here. Book your flights easily and travel the world!</p>
    <a href="{{ route('flights.index') }}" class="btn">Get Started</a>
</div>
@endsection
