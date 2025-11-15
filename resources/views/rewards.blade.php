@php

    use App\Models\Tutor;
    use App\Models\Reward;

    $rewards = Reward::all();
    $tutors = Tutor::all();

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <x-bladewind.notification />
</head>

<body class="font-poppins font-semibold bg-mainbackground">
    <div class="flex-1">
        <x-nav-bar />

        @if (session('success'))
            <div class="text-green-500 text-center my-4">{{ session('success') }}</div>
        @endif

        @if ($rewards->isEmpty())
            <div class="flex items-start justify-center pt-28 w-screen h-screen ">
                <div class="flex flex-col gap-y-4 justify-center items-center px-4">
                    <img src="{{ asset('/storage/images/drought.png') }}" class="w-20 h-20">
                    <div class="flex flex-col text-lg text-center  text-primary ">
                        <span class="text-2xl text-black font-black ">No Available Rewards Yet!</span>
                        <span class="leading-6 pt-2"><em>"Uh-oh! The rewards shelf is empty. Come back later for new
                                goodies!"</em></span>
                    </div>
                    <a href="{{ route('workspace.start') }}">
                        <button
                            class="justify-center w-auto bg-primary text-accent text-center font-poppins font-bold rounded-full px-5 py-5 h-10 text-lg border-2 border-black hover:bg-hover flex items-center space-x-2">
                            <span><a href="{{ route('workspace.start') }}">Back to Workspace</a></span>
                        </button>
                    </a>
                </div>
            </div>
        @else
            <div class="flex mt-28 justify-center items-center">
                <div class="grid grid-cols-3 gap-8">

                    @foreach ($rewards as $reward)
                        <div
                            class="flex flex-col justify-center h-[250px] w-[450px] overflow-hidden bg-accent border-black border-2 rounded-md">
                            
                            <div class="h-auto">
                                <h2
                                    class="font-dela uppercase h-[20%] text-2xl pt-6 text-center justify-items-start text-charcoal font-bold">
                                    {{ $reward->name }}
                                </h2>
                                <div class="flex h-[80%] p-6 justify-center items-center">
                                    <div
                                        class=" overflow-hidden flex border border-black rounded-md justify-center items-center h-32 w-32">
                                        <img class="w-full h-full object-cover"
                                            src="{{ asset('storage/' . $reward->image) }}" alt="{{ $reward->name }}">
                                    </div>

                                    <div class="flex items-center justify-center w-[70%] ml-4">
                                        <div>
                                            <p class="text-lg text-center">{{ $reward->description }}</p>
                                            <p class="text-lg text-center">{{ $reward->pointsReq }} Points Required</p>

                                            <form action="{{ route('rewards.redeem', $reward->id) }}" method="POST"
                                                class="flex justify-center">
                                                @csrf
                                                <button
                                                    class="w-full mt-4 border-black border-2 rounded-full text-accent bg-primary text-lg 
                                                hover:bg-hover uppercase tracking-widest font-bold"
                                                    type="submit">Collect</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error'))
            showNotification('{{ session('error') }}', 'Not enough points ❌', 'error');
            //<div class="text-red-500 text-center my-4">{{ session('error') }}</div>
        @endif
    });
</script>

</html>
