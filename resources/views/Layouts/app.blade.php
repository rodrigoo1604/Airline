<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @php
        $routeName = Route::currentRouteName();
    @endphp

    @if(file_exists(public_path('css/' . $routeName . '.css')))
        <link rel="stylesheet" href="{{ asset('css/' . $routeName . '.css') }}">
    @endif
</head>
<body>

    <x-header />

    <main>
        @yield('content')
    </main>

    <x-footer />

</body>
</html>
