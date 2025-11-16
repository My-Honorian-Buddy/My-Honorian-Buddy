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
    <style>
        /* Mobile-first approach */
        #mainLayout {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        
        #sidebarDiv {
            width: 100%;
            flex-shrink: 0;
            height: auto;
        }

        /* Inner sidebar content - mobile default is auto height */
        #sidebarDiv > div {
            height: auto !important;
        }

        /* Small devices (640px and up) */
        @media (min-width: 640px) {
            #sidebarDiv {
                width: 100%;
                height: auto;
            }
            #sidebarDiv > div {
                height: auto !important;
            }
        }

        /* Medium devices (768px and up) */
        @media (min-width: 768px) {
            #mainLayout {
                flex-direction: row;
                gap: 0;
            }
            #sidebarDiv {
                width: 24rem !important;
                flex-shrink: 0;
                min-width: 24rem;
                height: auto;
            }
            /* On desktop, make the sidebar content full height */
            #sidebarDiv > div {
                min-height: 100vh !important;
            }
            #sidebar-item {
                position: fixed;
            }
        }

        /* Large devices (1024px and up) */
        @media (min-width: 1024px) {
            #sidebarDiv {
                width: 28rem !important;
                min-width: 28rem;
                height: auto;
            }
            #sidebarDiv > div {
                min-height: 100vh !important;
            }
        }

        /* Extra large devices (1280px and up) */
        @media (min-width: 1280px) {
            #sidebarDiv {
                width: 24rem !important;
                min-width: 24rem;
                height: auto;
            }
            #sidebarDiv > div {
                min-height: 100vh !important;
            }
        }

        /* Prevent sidebar from shrinking */
        #mainLayout > div:last-child {
            
            min-width: 0;
        }
    </style>
</head>
<body class="font-poppins font-semibold bg-[#F5EFEF]">
    <!-- nav bar -->
    <x-nav-bar />
    
    @auth
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
    
    <div class="flex flex-col" id="mainLayout">
        <div class="w-full p-8 space-y-6 border-r border-black max-md:p-4 max-md:border-r-0 max-md:border-b max-md:border-black" id="sidebarDiv">
            <div class="flex justify-center w-full">
                {{ $sidebars }}
            </div>
        </div>
        
        {{-- Main Content --}}
        <div class="w-full flex-1" id="mainContent">
            <div class="mt-32 m-8 pb-32 max-md:mt-6 max-md:m-4 max-md:pb-16">
                <!-- Burger -->
                    
                    {{ $maincontent }}
            </div>
        </div>  
    </div>

</body>
{{-- footer --}}
<x-footer/>

</html>