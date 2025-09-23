<x-auth-layout> 
    <x-folder class="h-auto md:h-full">
        <x-slot name="header" class="text-center"> 
            <!-- 
                if user role is student then access the student table to get student first name
                else if user role is tutor then access the tutor table to get the tutor first name
            -->
            <div class="text-center">
                @if(Auth::check())
                    @php
                        $user = Auth::user();                   
                        $firstName = '';                        
                                                            
                        if ($user -> role === 'Student' && $user->student) {
                            $firstName = $user->Student->fname;
                        }
                        else if ($user -> role === 'Tutor' && $user->tutor) {
                            $firstName = $user -> Tutor -> fname;
                        }
                    @endphp
                    Hello, {{ $firstName ?: 'User' }}! 
                @else
                    Hello, Guest!       
                @endif
            </div>
        </x-slot>

<x-slot name="content">
     <!--HEADER-->
    <div class="text-center font-bold text-6xl my-8">
        Choose your Availability Date
    </div>

    <!--CONTAINER-->
    <div class="flex flex-row justify-center items-center md:w-3/4 mx-auto pt-4 space-x-20">

     <!--IMAGE-->    
    <div class="md:justify-center">
        <div class="w-auto md:w-1/2 flex justify-center md:mt-0" style="min-width:500px">
            <div class="flex flex-col px-4 justify-center">
                @if(Auth::check())
                    @if(Auth::user()->role === 'Student')
                        <img src="{{ asset('/images/profiling/Student.svg') }}" alt="placeholder" class="ml-[20px] max-w-full h-auto -mt-8">
                        <p class="text-center font-poppins font-bold text-[22px] mt-2">You're a Student!</p>
                    @elseif(Auth::user()->role === 'Tutor')
                        <img src="{{ asset('/images/profiling/Tutor.svg') }}" alt="placeholder" class="ml-[20px] max-w-full h-auto -mt-8">
                        <p class="text-center font-poppins font-bold text-[22px] mt-2">You're a Tutor!</p>
                    @endif
                @endif
            
            </div>
        </div>
    </div>

    <!--FORM-->
    <form method="POST" class="w-full md:w-1/2 flex flex-col justify-center" action="{{route('user.schedule.store')}}">
    @csrf
    
    <!-- Days -->
        <label for="Day" class="font-bold font-poppins text-xl md:text-2xl">Days</label>

            <div class="py-3">    
                <div class="font-poppins text-black">
                        <h3 class="text-lg font-bold font-poppins text-black mb-1">Weekdays:</h3>

                    <div class="flex space-x-2 flex-row justify-center gap-2 mb-2">
                        <!-- Monday-->
                        <div class="bg-accent2 my-3 py-[6px] rounded-full border-2 border-black shadow-custom-button text-primary text-[16px] text-center font-bold cursor-pointer sm:w-[160px]">
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days_week[]" id="monday" value="Monday">
                                <span class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200 ml-2"></span>
                                <span class="flex-1 text-center">Monday</span>
                            </label> 
                        </div> 

                         <!-- Tuesday-->
                         <div class="bg-accent2 my-3 py-[6px] rounded-full border-2 border-black shadow-custom-button text-primary text-[16px] text-center font-bold cursor-pointer sm:w-[160px]">
                             <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days_week[]" id="Tuesday" value="Tuesday">
                                <span class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200 ml-2"></span>
                                <span class="flex-1 text-center">Tuesday</span>
                             </label> 
                        </div> 

                        <!-- Wednesday-->
                        <div class="bg-accent2 my-3 py-[6px] rounded-full border-2 border-black shadow-custom-button text-primary text-[16px] text-center font-bold cursor-pointer sm:w-[160px]">
                             <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days_week[]" id="Wednesday" value="Wednesday">
                                <span class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200 ml-2"></span>
                                <span class="flex-1 text-center">Wednesday</span>
                             </label> 
                        </div> 
                    </div>
                        
                        <!-- Thursday and Friday-->
                        <div class="flex space-x-2 flex-row justify-center gap-2 mb-2">
                            <!-- Thursday-->
                            <div class="bg-accent2 my-3 py-[6px] rounded-full border-2 border-black shadow-custom-button text-primary text-[16px] text-center font-bold cursor-pointer sm:w-[160px]">
                                <label class="w-full h-full cursor-pointer flex items-center">
                                    <input type="checkbox" class="hidden peer" name="days_week[]" id="thursday" value="Thursday">
                                    <span class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200 ml-2"></span>
                                    <span class="flex-1 text-center">Thursday</span>
                                </label>
                            </div>

                            <!-- Friday-->
                            <div class="bg-accent2 my-3 py-[6px] rounded-full border-2 border-black shadow-custom-button text-primary text-[16px] text-center font-bold cursor-pointer sm:w-[160px]">
                                <label class="w-full h-full cursor-pointer flex items-center">
                                    <input type="checkbox" class="hidden peer" name="days_week[]" id="friday" value="Friday">
                                    <span class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200 ml-2"></span>
                                    <span class="flex-1 text-center">Friday</span>
                                </label>
                            </div>
                        </div>
                </div>
            </div>
      
       
            <div class="py-3">    
                <div class="font-poppins text-black">
                        <h3 class="text-lg font-bold font-poppins text-black mb-1">Weekends:</h3>

                    <div class="flex space-x-2 flex-row justify-center gap-2 mb-2">
               
                    
                    <div class="flex space-x-2 flex-row justify-center gap-2 -mb-5"> 
                    <!-- Saturday-->
                    <div class="bg-accent2 my-3 py-[6px] rounded-full border-2 border-black shadow-custom-button text-primary text-[16px] text-center font-bold cursor-pointer sm:w-[160px]">
                        <label class="w-full h-full cursor-pointer flex items-center">
                            <input type="checkbox" class="hidden peer" name="days_week[]" id="saturday" value="Saturday">
                            <span class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200 ml-2"></span>
                            <span class="font-poppins flex-1 text-center">Saturday</span>
                        </label>
                    </div>

                    <!-- Sunday-->
                    <div class="bg-accent2 my-3 py-[6px] rounded-full border-2 border-black shadow-custom-button text-primary text-[16px] text-center font-bold cursor-pointer sm:w-[160px]">
                        <label class="w-full h-full cursor-pointer flex items-center">
                            <input type="checkbox" class="hidden peer" name="days_week[]" id="sunday" value="Sunday">
                            <span class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200 ml-2"></span>
                            <span class="font-poppins flex-1 text-center">Sunday</span>
                        </label>
                    </div>
                </div>
                
            </div>


    <div class="flex flex-col">
        <!-- TIME -->
        <div class="flex flex-col w-full mb-10 md:mb-20 mt-10 md:-mt-0">
            <label for="time-from" class="font-bold font-poppins text-xl md:text-2xl mt-1 mb-1">Time</label>
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mt-1">
                <!-- THIS IS FOR START TIME -->
                <div class=" w-full">
                    <label for="start_time" class="font-poppins font-bold">Start Time:</label>
                    <input  type="time" id="start_time" name="start_time" class="border-2 font-semibold font-poppins text-2xl text-gray-900 text-center border-black rounded shadow-black w-full h-12" required>
                </div>
            
                <!-- THIS IS FOR END TIME -->
                <div class="w-full flex flex-col justify-start">
                    <label for="end_time" class="font-poppins font-bold">End Time:</label>
                    <input type="time" id="end_time" name="end_time" class="border-2 font-semibold font-poppins text-2xl text-gray-900 text-center border-black rounded shadow-black w-full h-12" required>
                </div>

            </div>

                <div class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                    <x-primary-button onclick="history.back()" class="bg-primary text-accent2 font-bold w-full md:max-w-[120px]">
                        {{ __('Back') }}
                    </x-primary-button>
                    <x-primary-button class="bg-accent2 text-primary font-bold w-full md:max-w-[120px]">
                        {{ __('Next') }}
                    </x-primary-button>
                </div>  
        </div>
    </div> 
</form>

</x-slot>
</x-folder>
</x-auth-layout>
