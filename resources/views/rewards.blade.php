@php
    
use App\Models\Tutor;
$tutors = Tutor::all();

// dd($rewards);
@endphp
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
        <x-nav-bar />

        @if(session('success'))
            <div class="text-green-500 text-center my-4">{{ session('success') }}</div>
        @endif

        

        <div class="flex mt-8 justify-center items-center">
            <div class="grid grid-cols-3 gap-8">
                    
                        @foreach ($rewards as $reward)
                        <div class="flex flex-col justify-center shadow-custom-button h-[300px] w-[500px] overflow-hidden bg-accent3 border-black border-2 rounded-[20px]">
                            <div class="bg-primary border-b-2 border-black">
                                <h2 class="text-2xl py-2 text-center justify-items-start text-accent2 font-bold">
                                    {{$reward->name}}
                                </h2>
                            </div>
                            <div class="flex h-full p-6 justify-center items-center">
                                <div class=" overflow-hidden flex border-2 border-black rounded-xl justify-center items-center mr-6 h-32 w-32">
                                    <img class="w-full h-full object-cover" src="{{ asset('storage/' . $reward->image) }}" alt="{{$reward->name}}" >
                                </div>
                                
                                <div class="w-[70%] ml-4">
                                    
                                    <p>{{$reward->description}}</p>
                                    <p>{{$reward->pointsReq}} Points Required</p>

                                <form action="{{route('rewards.redeem', $reward->id)}}" method="POST">
                                    @csrf
                                    <button class="mt-4 border-black border-2 rounded-full text-primary bg-accent2 text-lg px-6" type="submit">Collect</button> 
                                </form>

                                </div>
                            </div>
                        </div>
                        @endforeach
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('error'))
            showNotification('{{ session('error') }}','Not enough points :3', 'error');
            //<div class="text-red-500 text-center my-4">{{ session('error') }}</div>
        @endif
    });
</script>
</html>