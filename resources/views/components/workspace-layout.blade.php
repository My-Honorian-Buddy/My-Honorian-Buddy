<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
    <meta name="user-id" content="{{ Auth::id() }}">
    @endauth

    <title>My Honorian Buddy</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">

    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/chatify/burger.css') }}">
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
</head>

<body class="font-poppins font-semibold bg-[#F5EFEF]">

    <div class="flex-1">
        <!-- nav bar -->
        <x-nav-bar />

        <!-- component of all -->
        <x-workspace-content>
            

            {{-- main content --}}
            <x-slot name="maincontent">
                {{ $main_content }}
            </x-slot>

        </x-workspace-content>
    </div>

    {{-- Include call notification component for video calls --}}
    @auth
        @include('components.call-notification')
        
        {{-- Global COR Verification Notification --}}
        @if(Auth::user()->cor_status !== 'verified')
            <div class="fixed bottom-6 md:right-6 bg-accent text-primary px-5 py-6 border-2 
                border-primary shadow-xl rounded-md z-[9999] mr-8 max-md:mr-4 max-md:bottom-4">
                It appears that your COR has not been verified yet. <br>
                Please verify it
                <a class="font-bold underline" href="{{ route('cor.view') }}">
                    here
                </a>.
            </div>
        @endif
    @endauth

</body>
<script>
    AOS.init();
</script>
{{-- footer --}}
<x-footer />

</html>
