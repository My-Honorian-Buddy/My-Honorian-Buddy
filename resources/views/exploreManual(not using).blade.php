{{-- for manual --}}  
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Explore</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet"/>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <script src="/public/vendor/bladewind/js/dropmenu.js"></script>
    <script src="{{ asset('vendor/bladewind/js/notification.js') }}"></script>
    
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>    
    <x-bladewind.notification />
</head>

<body class="bg-secondary font-poppins font-semibold">
    
    <div class="flex min-h-screen overflow-auto items-start sticky top-0 " id="burger">
        <div class="flex-1">
        {{-- nav bar --}}
        <x-nav-bar/>
            <div class="flex flex-col-2 min-h-screen overflow-auto" x-data="{ isOpen: false }">
                {{-- sidebar --}}
                <form action="{{route('tutor.search')}}" id="" method="GET">
                <div class="w-96 p-6  space-y-4 border-r border-black":class="{ 'w-96 animate__animated animate__fadeInLeft animate__faster': isOpen, 'hidden': !isOpen }">
                    {{-- search filter button --}}
                    <div class="bg-accent p-1 rounded-xl border-2 border-black shadow-custom-button mt-8 mb-1 text-[22px] text-center font-bold cursor-pointer hover:bg-[#FFECEC] hover:text-[#8B3A3A]">
                        <button type="submit">SEARCH FILTER</button>
                    </div>
                    {{-- schedule --}}
                    <div class="">
                        <div class="bg-primary p-3 rounded-xl border-2 border-black shadow-custom-button text-accent2 text-[24px] text-center font-bold">
                            <h1>SCHEDULE</h1>
                        </div>
                        
                        {{-- days --}}
                        <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="monday" value="Monday">
                                <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                <span class="flex-1 text-center">MONDAY</span>
                            </label>
                        </div> 

                        <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="tuesday" value="Tuesday">
                                <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                <span class="flex-1 text-center">TUESDAY</span>
                            </label> 
                        </div>

                        <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="wednesday" value="Wednesday">
                                <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                <span class="flex-1 text-center">WEDNESDAY</span>
                            </label>
                        
                            @php
                                $showUsers = session('initiator') === 'filter-page' ? ($search ?? collect()) : $users;
                            @endphp

                        </div>
                        <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="thursday" value="Thursday">
                                <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                <span class="flex-1 text-center">THURSDAY</span>
                            </label>


                        </div>
                        <div class="bg-accent2 mt-3 mb-10 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="friday" value="Friday">
                                <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                <span class="flex-1 text-center">FRIDAY</span>
                            </label>
                        </div>
                    </div>


                    {{-- ratings --}}
                    <div class="">
                        <div class="bg-primary p-3 rounded-xl border-2 border-black shadow-custom-button text-accent2 text-[23px] text-center font-bold">
                            <h1>RATINGS</h1>
                        </div>

                        {{-- stars --}}
                        <div class="ml-14 mb-5">
                                <x-bladewind::rating
                                    size="medium"
                                    color="yellow"
                                    type="star"
                                    clickable="true"
                                    name="rating" />
                        </div>
                    </div>

                    {{-- experience --}}
                    <div class="bg-primary p-3 rounded-xl border-2 border-black shadow-custom-button text-accent2 text-[23px] text-center font-bold">
                        <h1>EXPERIENCE</h1>
                    </div>

                    <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                            <label class="w-full h-full cursor-pointer flex items-center justify-center">
                                <input type="checkbox" id="sessions-completed1" name="experience[]" value="1 - 5 sessions completed" class="bg-gray-300 h-6 w-6 text-primary rounded-full border-2 border-black cursor-pointer mr-3">
                                <span class="peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200">
                                1-5 SESSIONS COMPLETED
                            </label>
                    </div>

                    <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                            <label class="w-full h-full cursor-pointer flex items-center justify-center mr-2">
                                <input type="checkbox" id="sessions-completed2" name="experience[]" value="5 - 10 sessions completed" class="bg-gray-300 h-6 w-6 text-primary rounded-full border-2 border-black cursor-pointer mr-3">
                                <span class="select-none">
                            5-10 SESSIONS COMPLETED
                            </label>
                    </div>

                    <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                            <label class="w-full h-full cursor-pointer flex items-center justify-center">
                                <input type="checkbox" id="sessions-completed3" name="experience[]" value="10+ sessions completed" class="bg-gray-300 h-6 w-6 text-primary rounded-full border-2 border-black  cursor-pointer mr-3">
                                <span class="select-none">
                                    
                            10+ SESSIONS COMPLETED
                            </label>
                    </div>
                
                    {{-- price --}}
                    <div class="">
                        <div class="bg-primary mt-10 p-3 rounded-xl border-2 border-black shadow-custom-button text-accent2 text-[23px] text-center font-bold">
                            <h1>PRICE</h1>
                        </div>


                        {{-- any price --}}
                        <div class="bg-accent2 my-3 py-1 pl-5 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                                    <label class="w-full h-full cursor-pointer flex items-center justify-start">
                                    <input type="radio" id="sessions-completed" name="price" id="price" class="bg-gray-300 h-6 w-6 text-primary rounded-full border-2 border-black cursor-pointer mr-3 pl-2">
                                    <span class="select-none">
                                    ANY PRICE
                                    </label>
                        </div>


                        <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                            <label class="w-full h-full cursor-pointer flex items-center justify-start mx-5">
                                <input type="radio" name="price" class="bg-gray-300 h-6 w-6 rounded-full border-2 border-black shadow-custom-button" name="price_range" id="price" value="custom">
                                <div class="flex flex-col ml-4">
                                        {{-- min and max --}}
                                        <input type="text" name="min_price" id="minprice" placeholder="MIN" class="rounded-full mt-2 border-2 border-black shadow-custom-button placeholder:text-primary placeholder:text-[18px]" min="0">
                                        <input type="text" name="max_price" id="maxprice" placeholder="MAX" class="rounded-full mt-2 border-2 border-black shadow-custom-button placeholder:text-primary placeholder:text-[18px]" min="0">
                                        {{-- go button --}}
                                        <div class="bg-accent p-1 w-24 mt-2 mb-2 rounded-full border-2 border-black shadow-custom-button text-[20px] text-center font-bold cursor-pointer hover:bg-[#FFECEC] hover:text-[#8B3A3A]">
                                            <button type="submit">GO</button>
                                        </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                </div> 
                </form>
                
                {{-- main content --}}
                <div class="flex-1 p-6 overflow-y-auto items-start">
                <div class="sticky top-0">
                        {{-- burger nav --}}
                        <div class="burger sticky top-0" @click.prevent="isOpen = !isOpen ">
                            <div class="tham tham-e-squeeze tham-w-6">
                                <div class="tham-box">
                                    <div class="tham-inner"></div>
                                </div> 
                            </div>
                        </div>
                </div>
                    {{-- search bar,filters section,cards --}}
                    <div class="flex flex-col items-center h-screen space-y-4 ">
                            {{-- search bar --}}
                            <div class="relative w-full max-w-[800px]">
                                <input type="text" placeholder="Find Your Buddy..." class="w-full py-3 pl-4 pr-10 rounded-full border-2 border-black bg-gray-300 shadow-inner focus:outline-none font-bold focus:text-[20px] placeholder:text-[20px] text-gray-900"/>
                                <span class="absolute right-4 top-2.5 cursor-pointer">
                                    <button>
                                        <x-bladewind::icon name="magnifying-glass" />
                                    </button>
                                </span>
                            </div>

                            {{-- filters dropdown section --}}
                            <div class="flex space-x-4 mt-4 font-bold">

                                {{-- dropdown relevance --}}
                                <div class="relative">
                                <button id="relevance-btn" class="relative bg-accent w-40 my-3 text-left pl-4 py-1 border-2 border-black shadow-custom-button rounded-xl text-[18px] hover:bg-[#FFECEC]">
                                    Relevance
                                <span class="ml-3">&#9660;</span>
                                </button>
                                    <div id="dropdown-relevance" class="absolute w-[165px] bg-white border-2 border-black rounded-xl shadow-lg dropdown-menu hidden">
                                    <a href="#" class="dropdown-option block px-4 py-2 text-primary text-[16px] hover:bg-gray-200 rounded-t-xl">ASCENDING</a>
                                    <a href="#" class="dropdown-option block px-4 py-2 text-primary text-[16px] hover:bg-gray-200 rounded-b-xl">DESCENDING</a>
                                    </div>
                                </div>

                                {{-- dropdown rating --}}
                                <div class="relative">
                                <button id="rating-btn" class="relative bg-accent w-40 my-3 text-left pl-4 py-1 border-2 border-black shadow-custom-button rounded-xl text-[18px] hover:bg-[#FFECEC]">
                                    Rating
                                <span class="ml-12">&#9660;</span>
                                </button>
                                    <div id="dropdown-rating" class="absolute w-[165px] bg-white border-2 border-black rounded-xl shadow-lg dropdown-menu hidden">
                                    <a href="#" class="dropdown-option block px-4 py-2 text-primary text-[16px] hover:bg-gray-200 rounded-t-xl">ASCENDING</a>
                                    <a href="#" class="dropdown-option block px-4 py-2 text-primary text-[16px] hover:bg-gray-200 rounded-b-xl">DESCENDING</a>
                                    </div>
                                </div>

                                {{-- dropdown experience --}}
                                <div class="relative">
                                <button id="experience-btn" class="relative bg-accent w-40 my-3 text-left pl-4 py-1 border-2 border-black shadow-custom-button rounded-xl text-[18px] hover:bg-[#FFECEC]">
                                    Experience
                                <span class="ml-3">&#9660;</span>
                                </button>
                                    <div id="dropdown-experience" class="absolute w-[165px] bg-white border-2 border-black rounded-xl shadow-lg dropdown-menu hidden">
                                    <a href="#" class="dropdown-option block px-4 py-2 text-primary text-[16px] hover:bg-gray-200 rounded-t-xl">ASCENDING</a>
                                    <a href="#" class="dropdown-option block px-4 py-2 text-primary text-[16px] hover:bg-gray-200 rounded-b-xl">DESCENDING</a>
                                    </div>
                                </div>

                                {{-- dropdown schedule --}}
                                <div class="relative">
                                <button id="schedule-btn" class="relative bg-accent w-40 my-3 text-left pl-4 py-1 border-2 border-black shadow-custom-button rounded-xl text-[18px] hover:bg-[#FFECEC]">
                                    Schedule
                                <span class="ml-5">&#9660;</span>
                                </button>
                                    <div id="dropdown-schedule" class="absolute w-[165px] bg-white border-2 border-black rounded-xl shadow-lg dropdown-menu hidden">
                                    <a href="#" class="dropdown-option block px-4 py-2 text-primary text-[16px] hover:bg-gray-200 rounded-t-xl">ASCENDING</a>
                                    <a href="#" class="dropdown-option block px-4 py-2 text-primary text-[16px] hover:bg-gray-200 rounded-b-xl">DESCENDING</a>
                                    </div>
                                </div>
                            </div>

                            @if(session()->has('errors'))
                                <script>
                                    let errors = @json(session('errors')->all());
                                    let errorAlerts = '';

                                    for (const [key, message] of Object.entries(errors)) {
                                        errorAlerts += message + '\n';
                                    }
                                    
                                    alert(errorAlerts);
                                </script>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            
                            @php
                                $showUsers = session('initiator') === 'filter-page' ? ($search ?? collect()) : $users;
                            @endphp
                            
                                <x-card :users="$showUsers" :per-page="6" /> 
                                         
                        </div>
                        {{-- pagination --}}
                    
                    </div>
                
            </div>  
        {{-- ingat po tau baka may maburang closing div hahahahuhuhu --}}
        </div>
    </div>

    {{-- dropdown (relevance)--}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const relevanceBtn = document.querySelector('#relevance-btn');
        const dropdownRelevance = document.querySelector('#dropdown-relevance');
        const relevanceOptions = dropdownRelevance.querySelectorAll('.dropdown-option');

            relevanceBtn.addEventListener('click', function(e) {
            e.preventDefault();
            dropdownRelevance.classList.toggle('hidden');
        });

            relevanceOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                relevanceOptions.forEach(opt => opt.classList.remove('bg-primary', 'text-white'));
                option.classList.add('bg-primary', 'text-white');
                dropdownRelevance.classList.add('hidden');
            });
        });

            document.addEventListener('click', function(event) {
            if (!dropdownRelevance.contains(event.target) && !relevanceBtn.contains(event.target)) {
                dropdownRelevance.classList.add('hidden');
            }
        });
        });
    </script>



    {{-- dropdown (rating)--}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
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

    {{-- dropdown (experience)--}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
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

    {{-- dropdown (schedule)--}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
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

</body>
</html>                                                                 