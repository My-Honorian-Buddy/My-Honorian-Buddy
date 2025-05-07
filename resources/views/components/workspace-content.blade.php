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
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="burger.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <script src="{{ asset('vendor/bladewind/js/notification.js') }}"></script>
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <x-bladewind.notification />
    
</head>

<body class="font-poppins font-semibold bg-secondary">
    
<div class="flex-1">

    <!-- Sidebar --> 
    
    <div class="flex" x-data="{ isOpen: false }">
    <div class="w-96 min-h-screen p-8 space-y-6 border-r border-black" :class="{ 'w-96 animate__animated animate__fadeInLeft animate__faster': isOpen, 'hidden': !isOpen }">
            {{ $sidebars }}
        </div>
        
        {{-- Main Content --}}
        <div :class="{ 'w-full ': !isOpen, 'flex-1': isOpen } ">
            <div class=" m-8">
                <!-- Burger -->
                    <div  class="burger" @click.prevent="isOpen = !isOpen">
                        <div class="tham tham-e-squeeze tham-w-6">
                            <div class="tham-box mb-8">
                                <div class="tham-inner"></div>
                            </div>
                        </div>
                    </div>
                    {{ $maincontent }}
            </div>
        </div>  
    </div>
</div>

<script>  
    // Burger
    const tham = document.querySelector(".tham");
        
        tham.addEventListener('tham-active', () => {
        tham.classList.toggle('click');
        tham.style.setProperty('--animate-duration', '0.5s');
        });


</script>

</body>
</html>               