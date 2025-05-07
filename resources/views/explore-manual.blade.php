<x-workspace-layout>
    <x-slot name="sidebar_content">
        <form action="{{route('tutor.search')}}" id="" method="GET">
            <div class="lg:w-80 w-64 min-h-screen space-y-4 border-black">
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
                            <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                            <span class="flex-1 text-center">MONDAY</span>
                        </label>
                    </div> 

                    <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center">
                            <input type="checkbox" class="hidden peer" name="days[]" id="tuesday" value="Tuesday">
                            <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                            <span class="flex-1 text-center">TUESDAY</span>
                        </label> 
                    </div>

                    <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center">
                            <input type="checkbox" class="hidden peer" name="days[]" id="wednesday" value="Wednesday">
                            <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                            <span class="flex-1 text-center">WEDNESDAY</span>
                        </label>
                    </div>
                    
                    <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center">
                            <input type="checkbox" class="hidden peer" name="days[]" id="thursday" value="Thursday">
                            <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                            <span class="flex-1 text-center">THURSDAY</span>
                        </label>
                    </div>

                    <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center">
                            <input type="checkbox" class="hidden peer" name="days[]" id="friday" value="Friday">
                            <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                            <span class="flex-1 text-center">FRIDAY</span>
                        </label>
                    </div>

                    <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center">
                            <input type="checkbox" class="hidden peer" name="days[]" id="saturday" value="Saturday">
                            <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                            <span class="flex-1 text-center">SATURDAY</span>
                        </label>
                    </div>
                    
                    <div class="bg-accent2 mt-3 mb-10 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center">
                            <input type="checkbox" class="hidden peer" name="days[]" id="sunday" value="Sunday">
                            <span class="h-6 w-6 bg-gray-300 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                            <span class="flex-1 text-center">SUNDAY</span>
                        </label>
                    </div>
                </div>


                {{-- ratings --}}
                <div class="">
                    <div class="bg-primary p-3 rounded-xl border-2 border-black shadow-custom-button text-accent2 text-[23px] text-center font-bold">
                        <h1>RATINGS</h1>
                    </div>

                    {{-- stars --}}
                    <div class="lg:ml-10 ml-2 my-5">
                        <x-bladewind.rating
                        size="medium"
                        :rating="{{$rating}}"
                        rating="0"
                        color="yellow"
                        type="star"
                        clickable="true"/>
                        </div>
                    </div>

                {{-- experience --}}
                <div class="bg-primary p-3 rounded-xl border-2 border-black shadow-custom-button text-accent2 text-[23px] text-center font-bold">
                    <h1>EXPERIENCE</h1>
                </div>

                <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center justify-start">
                            <input type="checkbox" id="sessions-completed1" name="experience[]" value="1 - 5 sessions completed" class="hidden peer">
                            <span class="ml-2 bg-gray-300 h-6 w-6 text-primary rounded-full border-2 border-black cursor-pointer peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                            <span class="text-[19px] ml-2">1-5 SESSIONS COMPLETED</span>
                        </label>
                </div>

                <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center justify-start">
                            <input type="checkbox" id="sessions-completed2" name="experience[]" value="5 - 10 sessions completed" class="hidden peer">
                            <span class="ml-2 bg-gray-300 h-6 w-6 text-primary rounded-full border-2 border-black cursor-pointer peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                            <span class="text-[19px] ml-2">5-10 SESSIONS COMPLETED</span>
                        </label>
                </div>

                <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center justify-start">
                            <input type="checkbox" id="sessions-completed3" name="experience[]" value="10+ sessions completed" class="hidden peer">
                            <span class="ml-2 bg-gray-300 h-6 w-6 text-primary rounded-full border-2 border-black cursor-pointer peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                            <span class="text-[19px] ml-2">10+ SESSIONS COMPLETED</span>
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
                                <input type="radio" id="sessions-completed" name="price_range" id="price_any" class="hidden peer" value = "any">
                                <span class="bg-gray-300 h-6 w-6 text-primary rounded-full border-2 border-black cursor-pointer mr-3 pl-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                ANY PRICE
                                </label>
                    </div>


                    <div class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                        <label class="w-full h-full cursor-pointer flex items-center justify-start mx-5">
                            <input type="radio" class="hidden peer" name="price_range" id="price_custom" value="custom">
                            <span class="bg-gray-300 h-6 w-6 rounded-full border-2 border-black peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                            <div class="flex flex-col ml-4">
                                    {{-- min and max --}}
                                    <input type="text" name="min_price" id="minprice" placeholder="MIN" class="rounded-full mt-2 border-2 border-black shadow-custom-button placeholder:text-primary placeholder:text-[18px] w-48" min="0">
                                    <input type="text" name="max_price" id="maxprice" placeholder="MAX" class="rounded-full mt-2 border-2 border-black shadow-custom-button placeholder:text-primary placeholder:text-[18px] w-48" min="0">
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
    </x-slot>
    <x-slot name="main_content">

    <form action="{{route('tutor.search')}}" method="GET">
        <div class="flex flex-col items-center space-y-4">
            {{-- search bar --}}
            <div class="relative w-full max-w-[800px]">
                <input type="text" placeholder="Find Your Buddy..." name="query" value="{{request('query')}}"class="w-full py-3 pl-4 pr-10 rounded-full border-2 border-black bg-gray-300 shadow-inner focus:outline-none font-bold focus:text-[20px] placeholder:text-[20px] text-gray-900"/>
                <span class="absolute right-4 top-2.5 cursor-pointer">
                    <button type="submit"><x-bladewind::icon name="magnifying-glass" /></button>
                </span>
            </div>
    </form>
            @if(session('errors'))

            <script>
                ('Error!',
                {{ session('error') }},
                'error',
                15,
                'regular',
                'error_handling');
            </script>

            @endif
            
            @if(session()->has('errors'))
                <script>
                    let errors = @json(session('errors'));
                    let errorAlerts = '';

                    for (const [key, message] of Object.entries(errors)) {
                        errorAlerts += message + '\n';
                    }

                    alert('Error!', errorAlerts, 'error', 15, 'regular', 'error_handling');
                    
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

    {{-- dropdown (relevance)--}}
    {{--<script>
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
                    relevanceOptions.forEach(opt => opt.classList.remove('selected'));
                    option.classList.add('selected');
                    dropdownRelevance.classList.add('hidden');
                });
            });
    
                document.addEventListener('click', function(event) {
                if (!dropdownRelevance.contains(event.target) && !relevanceBtn.contains(event.target)) {
                    dropdownRelevance.classList.add('hidden');
                }
            });
            });


        </script>--}}
    
    
    
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
        
    </x-slot>

</x-workspace-layout>
