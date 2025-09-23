<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
</head>

<body class="font-poppins font-semibold bg-secondary">
    
<div class="flex-1">
        <!-- nav bar -->
        <x-nav-bar />
        
    <!-- Sidebar -->
    
    <div class="flex" x-data="{ isOpen: false }">
        <div class="w-96 min-h-screen p-8 space-y-6 border-r border-black" :class="{ 'w-96 animate__animated animate__fadeInLeft animate__faster': isOpen, 'hidden': !isOpen }">
                        <ul class="flex justify-center items-center space-y-6">
                            <li>
                                <a href="http://">
                                    <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold w-4/5 rounded-full px-8 py-1 h-11 text-l
                                    border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer">
                                    <x-bladewind.icon name="video-camera" class="justify-self-start" />
                                
                                        JOIN A NEW CALL
                                
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold w-4/5 rounded-full px-8 py-1 h-11 text-l border-2 border-black 
                                shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer">
                                    <x-bladewind.icon name="plus" class="justify-self-start" />
                                        CREATE A NEW CALL
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold w-4/5 rounded-full px-8 py-1 h-11 text-l border-2 border-black 
                                shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer">
                                    <x-bladewind.icon name="users" class="justify-self-start" />
                                        VIEW SESSIONS
                                </div>
                            </li>
                        </ul>
        </div>

        <div :class="{ 'w-full': !isOpen, 'flex-1': isOpen }">
                <section class="dasd sam-8">
                    <!-- Burger -->
                    <div  class="burger" @click.prevent="isOpen = !isOpen">
                        <div class="tham tham-e-squeeze tham-w-6">
                            <div class="tham-box mb-8">
                                <div class="tham-inner"></div>
                            </div>
                        </div>
                    </div>
                    {{-- container --}}
                    <section class="flex justify-center m-4 mt-8 ">

                        <div class="w-auto bg-gray-300 rounded-lg shadow-custom-button shadow-black border-black border-2">
                            <div class="flex items-center bg-accent2 w-full border-b-2 border-black py-2 rounded-t-[5px]">
                                <div class="flex w-full space-x-2 ml-4 mb-2">
                                    <span class="h-6 w-6 bg-primary border-2 border-black rounded-full"></span>
                                    <span class="text-l font-black">FULLY BOOKED</span>
                                </div>
                            </div>
                            
                        {{-- container --}} 
                            <div class="border-black p-4">
                                {{-- content --}}
                                <div class="flex flex-row items-center px-4">
                                    {{-- column 1 --}}
                                    <div class="ml-5">
                                        {{-- profile image --}}
                                        <div class="flex justify-center items-center space-x-4 w-[210px] h-[210px] py-2 px-2">
                                            <img src="https://picsum.photos/400" alt="Profile" class="border-4 border-black rounded-lg">
                                        </div> 
                                        
                                        
                                        {{-- set favorites button --}}
                                        <div class="mt-4 flex justify-center items-center">
                                            <a href="#">
                                                <button class="bg-primary text-accent2 text-center font-poppins font-bold rounded-full px-3 py-1 h-11 text-l border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] flex items-center space-x-2">
                                                    <span class="text-[18px]">ADD TO FAVORITES</span>
                                                </button>
                                            </a>
                                        </div>
                                        {{-- book appointment button --}}
                                        <div class="mt-4 flex justify-center items-center">
                                            <a href="#">
                                                <button class="bg-primary text-accent2 text-center font-poppins font-bold rounded-full px-3 py-1 h-11 text-l border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] flex items-center space-x-2">
                                                    <span class="text-[18px]">SET APPOINTMENT</span>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                
                                    {{-- column 2 --}}
                                    <div class="ml-10 mt-5 overflow-hidden">
                                        {{-- profile infos --}}
                                        <div class="flex-1">
                                            {{-- name --}}
                                            <p class="font-bold text-primary text-[16px] -mt-1">Name</p>
                                            <p class="font-bold text-[30px] -mt-2 mb-2">Asiong Salonga</p> 
                                            
                                            {{-- yr level and college program --}}
                                            <p class="font-bold text-primary text-[16px]">Year Level and College Program</p>
                                            <p class="font-bold text-[27px] -mt-1 mb-2">3rd Year BS in Vulcanizing Studies</p>
            
                                            {{-- quote --}}
                                            <p class="font-bold text-[25px] ml-20 -mt-1 mb-2 italic ">"Sa Simpanyawan Herbal Capsule Sigurado Ka!"</p>
            
                                            <div class="grid grid-cols-2">
                                                {{-- col1 --}}
                                                <div class="">
                                                    {{-- subject expertise --}}
                                                    <p class="font-bold text-primary text-[16px]">Subject Expertise</p>
                                                    <div class="flex justify-start space-x-4 mb-2">
                                                        {{-- subject 1 --}}
                                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">CSOS 313</p>
                                                        </div>
                                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">CSAC 313</p>
                                                        </div>
                                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">CSIAS 313</p>
                                                        </div>
                                                    </div>
                                                    {{-- experience --}}
                                                    <p class="font-bold text-primary text-[16px]">Experience</p>
                                                    <div class="flex justify-start space-x-4 mb-2">
                                                        {{-- subject 1 --}}
                                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">10+ COMPLETED SESSION</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- col2 --}}
                                                <div class="ml-5">
                                                    {{-- price per session --}}
                                                    <p class="font-bold text-primary text-[16px]">Price Per Session</p>
                                                    <div class="flex justify-start space-x-4 mb-2">
                                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">Php 999.00</p>
                                                        </div>
                                                    </div>
                                                    {{-- sschedule --}}
                                                    <p class="font-bold text-primary text-[16px]">Schedule</p>
                                                    <div class="flex justify-start space-x-4 mb-2">
                                                        {{-- sched 1 --}}
                                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">MONDAY</p>
                                                        </div>
                                                        {{-- sched 2 --}}
                                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">FRIDAY</p>
                                                        </div>
                                                    </div>
                                                </div>
            
                                            </div>
                                        </div>
                                    </div>     
                                </div> 
                            </div> 
                        </div>                                 
                    </section>          
                </section>


                <div class="grid grid-cols-3 gap-8">
                    <!-- left side column -->
                    <div class="col-span-3 space-y-8">
                        {{-- Reviews --}}
                        <section class="w-5/6 mx-auto m-8 flex justify-center">
                            {{-- container --}}
                            <div class="bg-gray-300 rounded-lg shadow-custom-button shadow-black border-black border-2">
                                <div class="flex bg-accent2 mb-2 items-center w-full border-b-2 border-black py-2 rounded-t-[5px]">
                                    <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                                        <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                                        <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                                        <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                                    </div>
                                <div class="flex w-full justify-end text-2xl text-accent text-stroke font-black mr-8">REVIEWS</div>
                            </div> 
                            
                            
                            <!-- Main Flex Row Container for Profile, Name, Rating, and Comment -->
                            <div class="flex items-center w-full my-4 space-x-4 px-10">
                                <!-- First Column - User's Profile -->
                                <div class="w-2/5 flex items-center">
                                    <div class="shrink-0">
                                        <img src="https://picsum.photos/400" alt="User's Avatar" class="w-20 h-20 rounded-full border-4 border-black">
                                    </div>
                                    
                                    <!-- Second Column - User's Name and Star Ratings -->
                                    <div class="flex flex-col ml-2 w-full h-full justify-start items-start space-y-1">
                                        
                                        <span class="font-bold text-primary text-[16px]">Alain Davidson De Leon</span>

                                        <!-- Star Rating -->
                                        <x-bladewind.rating size="small" rating="5" color="yellow" type="star" clickable="false" name="star-rating" />
                                        
                                    </div>
                                </div>
                                <!-- Third Column - Review Comment -->
                                <div class="flex-grow w-3/5">
                                    <p class="text-black my-2 font-semibold text-xl">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                                </div>
                            </div>
                            
                            <hr class="h-px border-0" style="border-top: 4px solid black;">

                            <!-- Second Main Flex Row Container for Profile, Name, Rating, and Comment -->
                            <div class="flex items-center w-full space-x-4 px-10">
                                <!-- First Column - User's Profile -->
                                <div class="w-2/5 flex items-center justify-center">
                                    <div class="shrink-0">
                                        <img src="https://picsum.photos/400" alt="User's Avatar" class="w-20 h-20 rounded-full border-4 border-black">
                                    </div>
                                    
                                    <!-- Second Column - User's Name and Star Ratings -->
                                    <div class="flex flex-col ml-2 w-full h-full justify-start items-start space-y-1">
                                        
                                        <span class="font-bold text-primary text-[16px]">ianjoshuabondocgonzales</span>

                                        <!-- Star Rating -->
                                        
                                        <x-bladewind.rating size="small" rating="5" color="yellow" type="star" clickable="false" name="star-rating" />
                                        
                                    </div>
                                </div>
                                <!-- Third Column - Review Comment -->
                                <div class="flex-grow w-3/5">
                                    <p class="text-black my-4 font-semibold text-xl">"Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>  
                
<!-- similar buddies -->
    <section class="m-4 flex flex-row w-full justify-between">
        <x-calendar/>
    </section>
    
        {{-- expertise level --}}
        <section class="m-4 mt-8 max-w-xs">
            {{-- container --}}
            <div class="bg-accent2 rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                <div class="bg-accent rounded-t-[20px] text-2xl text-accent text-stroke font-black p-3 border-b-2 border-black">
                    <div class="text-accent2">EXPERTISE LEVEL</div>
                </div>
                <div class="border-black p-4"></div>
                <div class="flex justify-center items-center">
                    <div class="grid grid-rows-3">
                        {{-- subject 1 expertise --}}
                        <div class="flex flex-row text-center m-5">
                            <p class="font-bold text-[25px] text-black mr-5 mt-3">CSAC 313</p>
                            <div class="-mt-8">
                                <x-bladewind::progress-circle
                                    animate="false"
                                    percentage="70"
                                    show_percent="false"
                                    shade="dark"
                                    color="red"
                                    circle_width="30"
                                    size="medium"
                                    show_label="true"
                                    show_percent="true" />
                                </div>
                        </div>
                        {{-- subject 2 expertise --}}
                        <div class="flex flex-row text-center m-5">
                            <p class="font-bold text-[25px] text-black mr-5 mt-3">CSOS 313</p>
                            <div class="-mt-8">
                                <x-bladewind::progress-circle
                                    animate="false"
                                    percentage="66"
                                    show_percent="false"
                                    shade="dark"
                                    color="red"
                                    circle_width="30"
                                    size="medium"
                                    show_label="true"
                                    show_percent="true" />
                                </div>
                        </div> 
                        {{-- subject 3 expertise --}}
                        <div class="flex flex-row text-center m-5">
                            <p class="font-bold text-[25px] text-black mr-5 mt-3">CSIAS 313</p>
                            <div class="-mt-8">
                                <x-bladewind::progress-circle
                                    animate="false"
                                    percentage="85"
                                    show_percent="false"
                                    shade="dark"
                                    color="red"
                                    circle_width="30"
                                    size="medium"
                                    show_label="true"
                                    show_percent="true" />
                            </div>
                        </div>
                    </div>   
                </div>
            </div>                                      
        </section> 



                            <section class="m-4 mt-8 max-w-xs">
                                    <!-- container -->
                                    <div class="bg-accent rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                                        <div class="bg-white rounded-t-[20px] text-2xl text-accent text-stroke font-black p-3 border-b-2 border-black">
                                            STATS
                                        </div>
                                        <div class="border-black p-4"></div>
                                        <!-- content -->
                                        <div class="text-center mt-2">
                                            <p class="font-bold text-2xl text-black">Date Joined:</p>
                                            <p class="font-bold text-2xl text-accent2 text-stroke">August 8, 2024</p>   

                                            <p class="font-bold text-2xl text-black">Sessions Completed:</p>
                                            <p class="font-bold text-2xl text-accent2 text-stroke">8 Sessions</p>

                                            <p class="font-bold text-2xl text-black">Students Tutored:</p>
                                            <p class="font-bold text-2xl text-accent2 text-stroke">3 students</p>
                                            
                                            <div class="border-black p-4"></div>
                                        </div>
                                    </div>
                            </section>       
                    </div>                         
                </div>

<!-- For the Calendar -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
                let currentDate = new Date();
                
                function createCalendar(date) {
                    const monthDays = document.querySelector('.grid-cols-7');
                    const month = date.getMonth();
                    const year = date.getFullYear();
                    const firstDay = new Date(year, month, 1).getDay();

                    const daysInMonth = new Date(year, month + 1, 0).getDate();

                    document.getElementById("calendar-month").innerText = 
                       new Intl.DateTimeFormat('en', { month: 'long', year: 'numeric' }).format(date);
                    
                    monthDays.innerHTML = '';
                    
                    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    daysOfWeek.forEach(day => {
                        const dayElement = document.createElement('div');
                        dayElement.classList.add('text-center', 'font-bold', 'text-black');
                        dayElement.innerText = day;
                        monthDays.appendChild(dayElement);
                    });

                    // This creates a new div element for each day before the first day of the month
                    for (let i = 0; i < firstDay; i++) {
                        const blank= document.createElement('div');
                        monthDays.appendChild(blank);
                    }

                    for (let day = 1; day <= daysInMonth; day++) {
                        // This creates a new div element for each day in the month
                        const dayElement = document.createElement('div');
                        dayElement.classList.add('text-center', "px-0.5", "m-2", "rounded-full");
                        dayElement.innerText = day;

                        if (
                            day === new Date().getDate() &&
                            month === new Date().getMonth() &&
                            year === new Date().getFullYear()
                        ) {
                            dayElement.classList.add("border-2", "border-black", "bg-primary", "text-yellow-300", "cursor-pointer");
                        }else {
                            dayElement.classList.add("hover:bg-primary", "hover:text-yellow-300", "cursor-pointer");
                        }
                        
                        monthDays.appendChild(dayElement);
                    }
                }

                document.getElementById('prev-month').addEventListener('click', () => {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    createCalendar(currentDate);
                });

                document.getElementById('next-month').addEventListener('click', () => {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    createCalendar(currentDate);
                });

                createCalendar(currentDate);
            });
</script>
                
     
    
                
    {{--  Burger --}}
    <script>  
    const tham = document.querySelector(".tham");
        
        tham.addEventListener('tham-active', () => {
        tham.classList.toggle('click');
        tham.style.setProperty('--animate-duration', '0.5s');
        });
    </script>

</body>
</html>