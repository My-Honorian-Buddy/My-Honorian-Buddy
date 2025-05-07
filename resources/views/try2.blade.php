<x-workspace-layout>
    <x-slot name="sidebar_content">
        <ul class="space-y-6">
            <li>
                <a href="http://">
                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m
                    border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center"> 
                    <x-bladewind.icon name="video-camera" class="justify-self-start" />                    
                        JOIN A NEW CALL    
                </div>
                    
                </a>
            </li> 
            <li>
                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m
                    border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center">
                    <x-bladewind.icon name="plus" class="justify-self-start" />
                        CREATE A NEW CALL
                </div>
            </li>
            <li>
                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m
                    border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center">
                    <x-bladewind.icon name="users" class="justify-self-start" />
                        VIEW SESSIONS
                </div>
            </li>
        </ul>
    </x-slot>

    <x-slot name="main_content">
        
    <section class="m-8">
            <!-- container -->
            <div class="w-full bg-gray-300 rounded-lg shadow-custom-button shadow-black border-black border-2">
                <div class="flex items-center bg-accent2 w-full border-b-2 border-black py-2 rounded-t-[5px]">
                    <div class="flex w-full space-x-2 ml-4 mb-2">
                        <span class="h-6 w-6 bg-primary border-2 border-black rounded-full"></span>
                        <span class="text-l font-black">FULLY BOOKED</span>
                    </div>
                </div>
                        
                <!-- div for the tutor's card -->
                <div class="flex w-full">
                    <!-- First column -->
                    <div class="flex flex-col justify-start mt-3">  
                        <img src="https://picsum.photos/400" alt="Profile" class="mb-4 ml-4 size-56 border-4 border-black rounded-lg">
                            <button class="bg-primary text-accent2 text-center font-poppins font-bold rounded-full ml-4 mb-4 h-11 text-l border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A]">
                                <span>ADD TO FAVORITES</span>
                            </button>
                            <button class="bg-primary text-accent2 text-center font-poppins font-bold rounded-full ml-4 mb-4 h-11 text-l border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A]">
                                <span>SET APPOINTMENT</span>
                            </button>
                    </div>
                        
                    <!-- Second column -->
                    <div class="flex flex-col ml-8 my-3">
                        <span class="font-bold text-red-900 leading-relaxed">First Name</span>
                        <span class="font-bold text-3xl -mt-1 leading-relaxed" name="fName">Asiong Salonga</span>
                        <span class="font-bold text-red-900 mt-4 leading-relaxed">Year Level and College Program</span>
                        <span class="font-bold text-3xl -mt-1 leading-relaxed" name="sYear">3rd Year BS in Vulcanizing Studies</span>
                        <p class="flex-grow items-center font-bold text-xl mt-6 ml-24 leading-relaxed" name="quote">"Sa Simpanyawan Herbal Capsule Sigurado Ka!"</p>

                        <div class="flex justify-between items-center mt-4">
                                        
                            <!-- Subject Expertise Section -->
                        <div class="flex flex-col space-y-3 mb-4">
                                <span class="font-bold text-red-900 leading-relaxed">Subject Expertise</span>
                                        
                            <div class="flex flex-wrap gap-2 mt-2 w-full max-w-lg ">
                                <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">CCS313</span>
                                <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">CSOS313</span>
                                <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">CSAC313</span>                      
                            </div>

                            <!-- Experience Section -->
                            <div class="flex flex-col">
                                <span class="font-bold text-red-900 leading-relaxed ml-1">Experience</span>
                            <div class="flex flex-wrap gap-2 mt-2 w-full max-w-lg">
                                <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">10+ SESSIONS COMPLETED</span>
                            </div>
                            </div>
                        </div>

                        <!-- Price Per Session Section -->
                        <div class="flex flex-col space-y-3 mb-4 ml-2">
                            <span class="font-bold text-red-900 leading-relaxed">Price Per Session</span>
                                                
                            <div class="flex flex-wrap gap-2 mt-2 w-full max-w-lg">
                                <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">Php 400.00</span>                            
                            </div>
            
                            <!-- Schedule Section -->
                            <div class="flex flex-col">
                                <span class="font-bold text-red-900 leading-relaxed">Schedule</span>
                                <div class="flex flex-wrap gap-2 mt-2 w-full max-w-lg ">
                                    <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">MONDAY</span>
                                </div>
                            </div>
                    </div>
                </div>
            </div> 
        </div>       
    </div>
    </section>

    {{-- Reviews --}}
    <section class="m-8">
        {{-- container --}}
        <div class="w-full bg-gray-300 rounded-lg shadow-custom-button shadow-black border-black border-2">
            <div class="flex bg-accent2 mb-2 items-center w-full border-b-2 border-black py-2 rounded-t-[5px]">
                <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                    <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                </div>

                <div class="flex w-full justify-end text-2xl text-accent text-stroke font-black mr-8">REVIEWS</div>
            </div> 
                            
                            
            <!-- Main Flex Row Container for Profile, Name, Rating, and Comment -->
            <div class="w-full flex items-center my-4 space-x-4 px-10">
                <!-- First Column - User's Profile -->
                <div class="w-2/5 flex items-center">
                    <div class="shrink-0">
                        <img src="https://picsum.photos/400" alt="User's Avatar" class="w-20 h-20 rounded-full border-4 border-black">
                    </div>
                                    
                    <!-- Second Column - User's Name and Star Ratings -->
                    <div class="flex flex-col ml-2 w-full h-full justify-start items-start space-y-1"> 
                        <span class="font-bold text-primary text-[16px]">Alain Davidson De Leon</span>

                        <!-- Star Rating -->
                        <x-bladewind.rating size="small" rating="5" color="yellow" type="star" clickable="false" name="star-rating" class="flex md:flex col sm:flex col" />
                                        
                    </div>
                </div>
                <!-- Third Column - Review Comment -->
                <div class="flex-grow w-3/5">
                    <p class="text-black my-2 font-semibold text-xl">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                </div>
            </div>
                            
            <hr class="h-px border-0" style="border-top: 4px solid black;">

            <!-- Second Main Flex Row Container for Profile, Name, Rating, and Comment -->
            <div class=" w-full flex items-center  space-x-4 px-10">
                <!-- First Column - User's Profile -->
                <div class="w-2/5 flex items-center justify-center">
                    <div class="shrink-0">
                        <img src="https://picsum.photos/400" alt="User's Avatar" class="w-20 h-20 rounded-full border-4 border-black">
                    </div>
                                    
                    <!-- Second Column - User's Name and Star Ratings -->
                    <div class="flex flex-col ml-2 w-full h-full justify-start items-start space-y-1">  
                                    <span class="font-bold text-primary text-[16px]">ianjoshuabondocgonzales</span>

                        <!-- Star Rating -->     
                        <x-bladewind.rating size="small" rating="5" color="yellow" type="star" clickable="false" name="star-rating" class="flex justify-center items-center gap-1 w-auto whitespace-nowrap" />       
                    </div>
                </div>
                <!-- Third Column - Review Comment -->
                <div class="flex-grow w-3/5">
                    <p class="text-black my-4 font-semibold text-xl">"Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
                </div>
            </div>
        </div>
    </section>

        <div class="grid grid-cols-4 w-full">
            <!-- Calendar -->
            <section class="col-span-3">
                <!-- container -->
                <div class="w-full mt-12">
                    <x-calendar />
                </div>
            </section>
            
             <!-- Expertise -->
             <div class="">
                <!-- expertise level -->
                <section class="ml-4 max-w-full mt-16">
                    <!-- container -->
                    <div class="bg-accent2 rounded-[20px] pb-2 -mt-4 shadow-custom-button shadow-black border-black border-2">
                        <div class="bg-accent rounded-t-[20px] text-2xl text-accent text-stroke font-black p-3 border-b-2 border-black">
                            <div class="text-accent2">EXPERTISE LEVEL</div>
                        </div>
                        <div class="border-black p-4"></div>
        
                        <div class="">
                            <div class="flex flex-col grid-cols-1 md:grid-cols-3 md:gap-8">
                                <!-- Subject 1 Expertise -->
                                <div class="flex flex-col items-center text-center md:flex-row md:text-left md:items-start">
                                    <p class="font-bold text-2xl md:text-xl lg:text-2xl text-black mr-0 md:mr-4">
                                        CSAC 313
                                    </p>
                                    <div>
                                        <x-bladewind::progress-circle
                                            animate="false"
                                            percentage="70"
                                            show_percent="true"
                                            shade="dark"
                                            color="red"
                                            circle_width="30"
                                            size="medium"
                                            show_label="true" />
                                    </div>
                                </div>
                        
                                <!-- Subject 2 Expertise -->
                                <div class="flex flex-col items-center text-center md:flex-row md:text-left md:items-start -mt-4">
                                    <p class="font-bold text-2xl md:text-xl lg:text-2xl text-black mr-0 md:mr-4 mt-3">
                                        CSOS 313
                                    </p>
                                    <div>
                                        <x-bladewind::progress-circle
                                            animate="false"
                                            percentage="66"
                                            show_percent="true"
                                            shade="dark"
                                            color="red"
                                            circle_width="30"
                                            size="medium"
                                            show_label="true" />
                                    </div>
                                </div>
                        
                                <!-- Subject 3 Expertise -->
                                <div class="flex flex-col items-center text-center md:flex-row md:text-left md:items-start -mt-4">
                                    <p class="font-bold text-2xl md:text-xl lg:text-2xl text-black mr-0 md:mr-4 mt-3">
                                        CSIAS 313
                                    </p>
                                    <div>
                                        <x-bladewind::progress-circle
                                            animate="false"
                                            percentage="85"
                                            show_percent="true"
                                            shade="dark"
                                            color="red"
                                            circle_width="30"
                                            size="medium"
                                            show_label="true" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div class="grid grid-cols-4 w-full">
            <section class="col-span-3 ml-10 max-w-[calc(100%-4rem)]">
                <!-- container -->
                <div class="w-full">
                    <div class="bg-accent2 rounded-[20px] pt-2 pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                        <div class="flex bg-white -mt-2 items-center w-full border-b-2 border-black py-2 rounded-t-[20px]">
                            <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                                <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                                <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                                <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                            </div>
                            <div class="flex w-full justify-end text-2xl text-accent2 text-stroke font-black mr-8">SIMILAR BUDDIES</div>
                        </div>
        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-2 mr-2 ml-2">
                            <!-- buddy #1 -->
                            <div class="flex flex-col items-center bg-gray-300 rounded-[20px] pt-5 pb-2 mb-4 shadow-black border-black border-2 w-full shrink-0 py-4">
                                <img src="https://picsum.photos/400" alt="Buddy 3" class="w-40 h-40 rounded-full border-4 border-black">
                                <p class="font-bold text-[20px] text-center mt-5">Ian Joshua Gonzales</p>
                            </div>
        
                            <!-- buddy #2 -->
                            <div class="flex flex-col items-center bg-gray-300 rounded-[20px] pt-5 pb-2 mb-4 shadow-black border-black border-2 w-full shrink-0 py-4">
                                <img src="https://picsum.photos/400" alt="Buddy 3" class="w-40 h-40 rounded-full border-4 border-black">
                                <p class="font-bold text-[20px] text-center mt-5">Antoinette</p>
                            </div>
        
                            <!-- buddy #3 -->
                            <div class="flex flex-col items-center bg-gray-300 rounded-[20px] pt-5 pb-2 mb-4 shadow-black border-black border-2 w-full shrink-0 py-4">
                                <img src="https://picsum.photos/400" alt="Buddy 3" class="w-40 h-40 rounded-full border-4 border-black">
                                <p class="font-bold text-[20px] text-center mt-5">Mireyl Fatima Nulud</p>
                            </div>
        
                            <!-- buddy #4 -->
                            <div class="flex flex-col items-center bg-gray-300 rounded-[20px] pt-5 pb-2 mb-4 shadow-black border-black border-2 w-full shrink-0 py-4">
                                <img src="https://picsum.photos/400" alt="Buddy 4" class="w-40 h-40 rounded-full border-4 border-black">
                                <p class="font-bold text-[20px] text-center mt-5 break-words">John Carl Angelo Bulaon</p>
                            </div>
        
                            <!-- buddy #5 -->
                            <div class="flex flex-col items-center bg-gray-300 rounded-[20px] pt-5 pb-2 mb-4 shadow-black border-black border-2 w-full shrink-0 py-4">
                                <img src="https://picsum.photos/400" alt="Buddy 5" class="w-40 h-40 rounded-full border-4 border-black">
                                <p class="font-bold text-[20px] text-center mt-5">Dwight Jairo Pingul</p>
                            </div>
        
                            <!-- buddy #6 -->
                            <div class="flex flex-col items-center bg-gray-300 rounded-[20px] pt-5 pb-2 mb-4 shadow-black border-black border-2 w-full shrink-0 py-4">
                                <img src="https://picsum.photos/400" alt="Buddy 6" class="w-40 h-40 rounded-full border-4 border-black">
                                <p class="font-bold text-[20px] text-center mt-5">Cecil Rico Trinidad</p>
                            </div>
        
                            <!-- buddy #7 -->
                            <div class="flex flex-col items-center bg-gray-300 rounded-[20px] pt-5 pb-2 mb-4 shadow-black border-black border-2 w-full shrink-0 py-4">
                                <img src="https://picsum.photos/400" alt="Buddy 2" class="w-40 h-40 rounded-full border-4 border-black">
                                <p class="font-bold text-[20px] text-center mt-5">John Daniel Canlas</p>
                            </div>
        
                            <!-- buddy #8 -->
                            <div class="flex flex-col items-center bg-gray-300 rounded-[20px] pt-5 pb-2 mb-4 shadow-black border-black border-2 w-full shrink-0 py-4">
                                <img src="https://picsum.photos/400" alt="Buddy 2" class="w-40 h-40 rounded-full border-4 border-black">
                                <p class="font-bold text-[20px] text-center mt-5">Nion Czryll Tongol</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

    
            <section class="ml-4 max-w-full">
                <div class="bg-accent rounded-[20px] pb-3 mt-1 shadow-custom-button shadow-black border-black border-2">
                    <!-- Header -->
                    <div class="bg-white rounded-t-[20px] text-2xl md:text-2xl text-accent text-stroke font-black p-4 border-b-2 border-black text-center">
                        STATS
                    </div>

                    <!-- Stats Content -->
                    <div class=" p-4 md:p-6 text-center md:text-left">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-20 -mt-2">
                                        
                            <!-- Date Joined -->
                            <div class="">
                                <p class="font-bold text-2xl md:text-2xl text-black">Date Joined:</p>
                                <p class="font-bold text-2xl md:text-xl text-accent2 text-stroke">August 8, 2024</p>
                            </div>
                        
                            <!-- Sessions Completed -->
                            <div>
                                <p class="font-bold text-2xl md:text-2xl text-black">Sessions Completed:</p>
                                <p class="font-bold text-2xl md:text-xl text-accent2 text-stroke">8 Sessions</p>
                            </div>
                        
                            <!-- Students Tutored -->
                            <div>
                                <p class="font-bold text-2xl md:text-2xl text-black">Students Tutored:</p>
                                <p class="font-bold text-2xl md:text-xl text-accent2 text-stroke">3 students</p>
                            </div>

                            <!-- Hours of Working -->
                            <div>
                                <p class="font-bold text-2xl md:text-2xl text-black">Hours Working:</p>
                                <p class="font-bold text-2xl md:text-xl text-accent2 text-stroke">90 hours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section> 
        </div>
    </x-slot>
</x-workspace-layout>

 <!-- Footer -->
<footer class="w-full text-black">
    <div class="border-t border-black mx-0 px-0"></div>
    

    <div class="container mx-auto mt-4 flex justify-between items-start">
        <div>
            <div class="text-[20px]">
                <p class=" font-semibold text-primary">
                    Your Path to the Perfect Buddy <br/>
                    and a Better Learning Experience.
                </p>
            </div>
            
            <div class="mt-6 flex space-x-8 text-primary font-bold">
                <a href="#" class="hover:underline text-[22px]">Workspace</a>
                <a href="#" class="hover:underline text-[22px]">Explore</a>
                <a href="#" class="hover:underline text-[22px]">About us</a>
            </div>
            
            <!-- Footer Copyright text-->
            <p class="mt-1 text-[15px] text-primary font-bold">
                ©2024 My Honorian Buddy. All rights reserved.
            </p>
        </div>
        
        <div class="text-right">
            <p class="text-[18px] text-black-600 font-bold">
            Got questions? We’re here to help!
            </p>

            {{-- address, gmail, contact --}}
            <address class="not-italic mt-2 text-[15px]">
                <i>Cabambangan, Bacolor, Pampanga</i> <br/>
                <a href="mailto:myhonorianbuddy@gmail.com" class="hover:underline">
                    <i>myhonorianbuddy@gmail.com</i>
                </a> <br/>
                <i>+63 (987) 654-321</i>
            </address>

            <!-- Add icon library -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            {{-- social media --}}
            <div class="mt-4 flex justify-end space-x-4">
                {{-- instagram --}}
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-black">
                    <a href="#" class="fa fa-instagram text-white text-3xl"></a>
                </div>
                {{-- facebook --}}
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-black">
                    <a href="#" class="fa fa-facebook text-white text-3xl"></a>
                </div>
                {{-- twitter --}}
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-black">
                    <a href="#" class="fa fa-twitter text-white text-3xl"></a>
                </div>
            </div>

        </div>
    </div>

    <div class="container mx-auto mt-15 text-center relative h-64">
        <div class="absolute inset-0 flex justify-center items-center">
            <img src="https://picsum.photos/400" alt="myhonorianbuddy" class="object-cover w-full h-1/2">
        </div>
    </div>
</footer>
