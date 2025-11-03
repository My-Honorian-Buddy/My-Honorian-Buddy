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

<body class="font-poppins font-semibold bg-[#F5EFEF] min-h-screen">
    @php
        $authUser = Auth::user();
    @endphp

    <div class="flex-1">
        <!-- nav bar -->
        <x-nav-bar />


        <form action="{{ route('tutor.search') }}" method="GET">
            <div class="flex flex-col items-center space-y-4">
                {{-- search bar --}}
                <div class="relative w-full mt-10 max-w-[800px]">
                    <input type="text" placeholder="Find Your Buddy..." name="query"
                        value="{{ request('query') }}"class="w-full py-3 pl-4 pr-10 rounded-full
                    border-2 border-black bg-secondary shadow-inner focus:outline-none font-bold placeholder:text-[20px] text-gray-900" />
                    <span class="absolute right-4 top-3 cursor-pointer">
                        <button type="submit"><x-bladewind::icon name="magnifying-glass" /></button>
                    </span>
                </div>
            </div>
        </form>

        <div class="w-full h-[60px] flex justify-center items-center">
            <div class="w-[80%] h-[80%] m-10 flex items-center justify-center">
                <x-bladewind.dropmenu hide_after_click="false" position="right">
                    <x-slot:trigger>
                        <div class="flex w-30 h-[80%] cursor-pointer mx-2 py-2 px-3 text-charcoal text-center">
                            <div class="hover:underline ">Name</div>

                            <div>
                                <x-bladewind.icon name="chevron-down" class="!h-4 !w-4 ml-2" />
                            </div>
                        </div>
                    </x-slot:trigger>
                    <form action="{{ route('tutor.search') }}" id="sortForm" method="GET">
                        <x-bladewind.dropmenu-item hover="false">
                            <div class="w-full">
                                <input type="radio" name="sort" value="asc" id="sort-asc" class="sr-only peer"
                                    onchange="document.getElementById('sortForm').submit()"
                                    {{ request('sort') == 'asc' ? 'checked' : '' }} />
                                <label for="sort-asc"
                                    class="flex w-full items-center justify-center cursor-pointer gap-4 rounded border border-charcoal bg-accent p-3 
                                    text-sm font-bold transition-colors text-gray-700 peer-checked:text-white hover:bg-primary/5 peer-checked:bg-primary">
                                    <p class="text-lg px-8">A - Z</p>
                                </label>
                            </div>
                        </x-bladewind.dropmenu-item>

                        <x-bladewind.dropmenu-item hover="false">
                            <div class="w-full">
                                <input type="radio" name="sort" value="desc" id="sort-desc" class="sr-only peer"
                                    onchange="document.getElementById('sortForm').submit()"
                                    {{ request('sort') == 'desc' ? 'checked' : '' }} />
                                <label for="sort-desc"
                                    class="flex w-full items-center justify-center px-2 cursor-pointer gap-4 rounded border border-charcoal bg-accent p-3 
                                    text-sm font-bold transition-colors text-gray-700 peer-checked:text-white hover:bg-primary/5 peer-checked:bg-primary">
                                    <p class="text-lg px-8">Z - A</p>
                                </label>
                            </div>
                        </x-bladewind.dropmenu-item>
                    </form>
                </x-bladewind.dropmenu>
                <x-bladewind.dropmenu hide_after_click="false" class='w-60'>
                    <x-slot:trigger>

                        <div class="flex w-32 h-[80%] mx-2 py-2 px-3 text-charcoal text-center cursor-pointer">
                            <div class="hover:underline">Schedule</div>

                            <div>
                                <x-bladewind.icon name="chevron-down" class="!h-4 !w-4 ml-2" />
                            </div>
                        </div>


                    </x-slot:trigger>
                    <form action="{{ route('tutor.search') }}" id="" method="GET">
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="monday" value="Monday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 hover:peer-checked:bg-accent2 
                                    hover:peer-checked:border-accent2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">MONDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="tuesday"
                                    value="Tuesday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">TUESDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="wednesday"
                                    value="Wednesday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">WEDNESDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="thursday"
                                    value="Thursday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">THURSDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="friday"
                                    value="Friday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">FRIDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="saturday"
                                    value="Saturday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">SATURDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="sunday"
                                    value="Sunday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">SUNDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item hover="false">
                            <button type="submit"
                                class="w-full h-full text-center bg-accent text-primary rounded-sm hover:text-accent tracking-widest
                                        border-2 border-charcoal hover:shadow-custom-button hover:bg-primary py-2 transition duration-200
                                        font-extrabold">
                                APPLY
                            </button>
                        </x-bladewind.dropmenu-item>
                    </form>
                </x-bladewind.dropmenu>

                <x-bladewind.dropmenu hide_after_click="false" class='w-60'>
                    <x-slot:trigger>
                        <div class="flex w-32 h-[80%] mx-2 py-2 px-3 cursor-pointer text-charcoal text-center">
                            <div class="hover:underline">Ratings</div>

                            <div>
                                <x-bladewind.icon name="chevron-down" class="!h-4 !w-4 ml-2" />
                            </div>
                        </div>
                    </x-slot:trigger>
                    <form action="{{ route('tutor.search') }}" id="" method="GET">
                        <div class="flex items-center justify-center">
                            <div>
                                <x-bladewind.dropmenu-item hover="false">
                                    <div
                                        class="py-1 px-4 text-primary text-[20px] text-center font-bold cursor-pointer">
                                        <x-bladewind.rating size="small" :rating="{{ $rating }}" rating="0"
                                            color="yellow" type="star" clickable="true" />
                                    </div>

                                </x-bladewind.dropmenu-item>
                                <x-bladewind.dropmenu-item hover="false">
                                    <button type="submit"
                                        class="w-full h-full text-center bg-accent text-primary rounded-sm hover:text-accent tracking-widest
                                        border-2 border-charcoal hover:shadow-custom-button hover:bg-primary py-2 transition duration-200
                                        font-extrabold">
                                        APPLY
                                    </button>
                                </x-bladewind.dropmenu-item>
                            </div>
                        </div>
                    </form>
                </x-bladewind.dropmenu>

                <x-bladewind.dropmenu hide_after_click="false">
                    <x-slot:trigger>
                        <div class="flex w-36 h-[80%]  mx-2 py-2 px-3 cursor-pointer text-charcoal text-center">
                            <div class="hover:underline">Experience</div>

                            <div>
                                <x-bladewind.icon name="chevron-down" class="!h-4 !w-4 ml-2" />
                            </div>
                        </div>
                    </x-slot:trigger>
                    <form action="{{ route('tutor.search') }}" id="" method="GET">
                        <x-bladewind.dropmenu-item hover="false">
                            <div class="py-1 text-primary text-[20px] text-center font-bold cursor-pointer">
                                <div class="flex flex-col mx-2">
                                    <div class="flex items-center justify-center">
                                        <input type="text" name="min_exp" id="" placeholder="MIN"
                                            class="rounded-sm mt-2 border border-black placeholder:text-primary/70
                                                placeholder:text-[18px] w-24 placeholder:text-center"
                                            min="0">
                                        <span class="mx-4">
                                            -
                                        </span>
                                        <input type="text" name="max_exp" id="" placeholder="MAX"
                                            class="rounded-sm mt-2 border border-black placeholder:text-primary/70
                                                placeholder:text-[18px] w-24 placeholder:text-center"
                                            min="0">
                                    </div>
                                    <div
                                        class="bg-accent p-1 w-full mt-4 rounded-sm border-2 border-charcoal transition duration-200
                                                tracking-widest text-[20px] text-center font-bold cursor-pointer hover:shadow-custom-button hover:bg-primary hover:text-accent">
                                        <button type="submit">GO</button>
                                    </div>
                                </div>

                            </div>
                        </x-bladewind.dropmenu-item>
                    </form>
                </x-bladewind.dropmenu>

            </div>
        </div>
    </div>

    </form>
    @if (session('errors'))
        <script>
            ('Error!',
                {{ session('error') }},
                'error',
                15,
                'regular',
                'error_handling');
        </script>
    @endif

    @if (session()->has('errors'))
        <script>
            let errors = @json(session('errors'));
            let errorAlerts = '';

            for (const [key, message] of Object.entries(errors)) {
                errorAlerts += message + '\n';
            }

            alert('Error!', errorAlerts, 'error', 15, 'regular', 'error_handling');
        </script>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @php
        $showUsers = session('initiator') === 'filter-page' ? $search ?? collect() : $users;
    @endphp

    <x-card :users="$showUsers" :per-page="1" />

    </div>


    {{-- dropdown (rating) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ratingBtn = document.querySelector('#rating-btn');
            const dropdownRating = document.querySelector('#dropdown-rating');
            const ratingOptions = dropdownRating.querySelectorAll('.dropdown-option');


            ratingBtn.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownRating.classList.toggle('hidden');
            });


            ratingOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    ratingOptions.forEach(opt => opt.classList.remove('bg-maroon', 'text-white'));
                    option.classList.add('bg-maroon', 'text-white');
                    dropdownRating.classList.add('hidden');
                });
            });


            document.addEventListener('click', function(event) {
                if (!dropdownRating.contains(event.target) && !ratingBtn.contains(event.target)) {
                    dropdownRating.classList.add('hidden');
                }
            });
        });
    </script>

    {{-- dropdown (experience) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const experienceBtn = document.querySelector('#experience-btn');
            const dropdown = document.querySelector('#dropdown-experience');
            const dropdownOptions = document.querySelectorAll('.dropdown-option');


            experienceBtn.addEventListener('click', function(e) {
                e.preventDefault();
                dropdown.classList.toggle('hidden');
            });


            dropdownOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdownOptions.forEach(opt => opt.classList.remove('bg-maroon', 'text-white'));
                    option.classList.add('bg-maroon', 'text-white');
                    dropdown.classList.add('hidden');
                });
            });


            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target) && !experienceBtn.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
    </script>

    {{-- dropdown (schedule) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scheduleBtn = document.querySelector('#schedule-btn');
            const dropdownSchedule = document.querySelector('#dropdown-schedule');
            const scheduleOptions = dropdownSchedule.querySelectorAll('.dropdown-option');


            scheduleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownSchedule.classList.toggle('hidden');
            });


            scheduleOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    scheduleOptions.forEach(opt => opt.classList.remove('bg-maroon', 'text-white'));
                    option.classList.add('bg-maroon', 'text-white');
                    dropdownSchedule.classList.add('hidden');
                });
            });


            document.addEventListener('click', function(event) {
                if (!dropdownSchedule.contains(event.target) && !scheduleBtn.contains(event.target)) {
                    dropdownSchedule.classList.add('hidden');
                }
            });
        });
    </script>


    <style>
        .hidden {
            display: none !important;
        }

        .bg-maroon {
            background-color: #800000;
        }

        .text-white {
            color: #FFFFFF;
        }
    </style>
    </div>

</body>
{{-- footer --}}
<x-footer />

</html>
