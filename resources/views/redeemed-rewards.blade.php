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
<body class="font-poppins w-full h-full font-semibold bg-mainbackground">
    <div class="flex-1 w-full h-full">
        <x-nav-bar />

        @if(session('success'))
            <div class="text-green-500 text-center my-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="text-red-500 text-center my-4">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="text-yellow-500 text-center my-4">{{ session('info') }}</div>
        @endif

        <div class="flex mt-28 justify-center items-center">
            <div class="grid grid-cols-3 gap-8">

                @forelse($redemptions as $item)
                        <div class="flex flex-col m-2 justify-center h-[250px] w-[450px] overflow-hidden bg-accent border-charcoal border-2 rounded-md">
                            <div class="h-auto">
                                <h2 class="font-dela uppercase h-[20%] text-2xl pt-6 text-center justify-items-start text-charcoal font-bold">{{$item->reward->name}}</h2>
                                <div class="flex h-[80%] p-6 justify-center items-center">
                                    <div class="flex h-full justify-center items-center">
                                    
                                    <div class="overflow-hidden flex border-2 border-black rounded-xl justify-center items-center mr-6 h-32 w-32">
                                        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $item->reward->image) }}" alt="{{$item->reward->name}}" srcset="">
                                    </div>
                                        <div class="w-[70%]">
                                            
                                            <p>{{$item->reward->description}}</p> 
                                            <p>{{$item->reward->pointsReq}} Points Required</p>

                                            <p>STATUS: 
                                                <span class="capitalize {{
                                                $item->status === 'accepted' ? 'text-green-600' : 
                                                ($item->status === 'rejected' ? 'text-red-600' : 
                                                ($item->status === 'claimed' ? 'text-gray-600' : 'text-yellow-600'))
                                                }}">
                                                    {{$item->status}}
                                                </span>
                                            </p>

                                            @if($item->status === 'accepted')
                                                
                                                    <form action="{{route('rewards.claim', $item->id)}}" method="POST">
        
                                                        @csrf

                                                        <button type="submit" class="mt-4 justify-center w-[80%] bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-5 py-3 ml-2 h-10 text-[12px] border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] flex items-center space-x-2">
                                                            CLAIM THIS REWARD
                                                        </button>

                                                    </form>
                                                    
                                            @elseif ($item->status === 'claimed')
                                                <p class="text-gray-600">YOU HAVE ALREADY CLAIMED THIS REWARD</p>
                                            @elseif ($item->status === 'rejected')
                                                <p class="text-red-600">THIS REQUEST WAS REJECTED</p>
                                            @elseif ($item->status === 'pending')
                                                <p class="text-yellow-600">THIS REQUEST IS WAITING FOR ADMIN APPROVAL</p>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                @empty
                        </div>
                        </div>
                        <div class="flex items-start justify-center pt-28 w-screen h-screen ">
                            
                                <div class="flex flex-col gap-y-4 justify-center items-center px-4">
                                    <img src="{{ asset('images/snowman.svg') }}">
                                    <div class="flex flex-col text-lg text-center  text-primary ">
                                        <span class="text-2xl text-black font-black ">No Redeem Rewards Yet!</span>
                                        <span class="leading-6 pt-2"><em>"Don’t let your points gather dust — redeem a reward today!"</em></span>
                                    </div>
                                    <a href="{{route('connect.student')}}">
                                        <button class="justify-center w-auto bg-primary text-accent text-center font-poppins font-bold rounded-full px-5 py-5 h-10 text-lg border-2 border-black hover:bg-hover flex items-center space-x-2">
                                        <span><a href="{{route('rewards.view')}}">SEE AVAILABLE REWARDS</a></span>    
                                        </button>
                                    </a>
                                </div>
                            
                            
                        </div>
                        
                @endforelse
  
            
        
        
    </div>
</body>
</html>