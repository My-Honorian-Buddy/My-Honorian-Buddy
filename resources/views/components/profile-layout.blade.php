<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Honorian Buddy</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
    
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="burger.css">
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <x-bladewind.notification />
</head>
<body class="font-poppins font-semibold bg-secondary">
    
<div class="flex-1">
        <!-- nav bar -->
        <x-nav-bar />
        
    <div class="flex" >
        <div class="w-96 min-h-screen p-8 space-y-6 border-r border-black">
            <div class="w-full">
                {{ $sidebars }}
            </div>
        </div>
        
        {{-- Main Content --}}
        <div class="w-full">
            <div class="mt-32 m-8">
                <!-- Burger -->
                    
                    {{ $maincontent }}
            </div>
        </div>  
    </div>
</div>

</body>
{{-- footer --}}
<x-footer/>

</html>