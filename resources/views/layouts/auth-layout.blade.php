<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Honorian Buddy</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        
    </style>
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="{{ asset('vendor/bladewind/js/notification.js') }}"></script>
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
    <x-bladewind.notification />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="overflow-x-hidden bg-accent">
    <div class="flex justify-center items-center bg-accent">
       {{ $slot }}
    </div>
</body>
</html>