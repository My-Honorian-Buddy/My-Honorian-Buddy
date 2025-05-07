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
        <div class="w-full flex flex-col md:flex-row items-center my-4 space-x-4 px-10">
            <!-- First Column - User's Profile -->
            <div class="w-full md:w-2/5 flex items-center justify-center">
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
            <div class="flex-grow w-full md:w-3/5 mt-4 md:mt-0">
                <p class="text-black my-2 font-semibold text-xl">"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
            </div>
        </div>
                        
        <hr class="h-px border-0" style="border-top: 4px solid black;">

        <!-- Second Main Flex Row Container for Profile, Name, Rating, and Comment -->
        <div class=" w-full flex flex-col md:flex-row items-center space-x-4 px-10">
            <!-- First Column - User's Profile -->
            <div class="w-full md:2/5 flex items-center justify-center">
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
            <div class="flex-grow w-full md:w-3/5 mt-4 md:mt-0">
                <p class="text-black my-4 font-semibold text-xl">"Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</p>
            </div>
        </div>
    </div>
</section>