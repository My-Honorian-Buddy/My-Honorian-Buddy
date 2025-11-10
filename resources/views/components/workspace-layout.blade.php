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
    <link rel="stylesheet" href="burger.css">
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
    @endauth

    <script>
        (function() {
            const progressEl = document.getElementById('scroll-progress');

            function updateProgress() {
                const scrollTop = window.scrollY || document.documentElement.scrollTop;
                const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
                if (progressEl) progressEl.style.width = progress + '%';
            }
            window.addEventListener('scroll', updateProgress, {
                passive: true
            });
            window.addEventListener('resize', updateProgress);
            document.addEventListener('DOMContentLoaded', updateProgress);
        })();
    </script>
</body>
<script>
    AOS.init();
</script>
{{-- footer --}}
<x-footer />

</html>
