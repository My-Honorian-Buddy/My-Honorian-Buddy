<x-auth-layout>
    <x-folder class="h-full">
        <x-slot name="header">
            Tell us more! 
        </x-slot>
        
        <x-slot name="content">
            <div class="text-center font-bold text-6xl my-8">
                What's your rate and experiences?
            </div>

            <div class="flex flex-col pb-44 md:flex-row md:space-x-6 sm:pb-64 lg:pb-20">
                <!-- Left side -->
                <div class="w-auto md:w-1/2 flex justify-center mt-6 md:mt-0">
                    <div class="flex flex-col px-4 justify-center ">
                        <img src="{{ asset('/images/profiling/Tutor.svg') }}" alt="placeholder" class="ml-[20px] max-w-full h-auto -mt-8">
                        <p class="text-center font-poppins font-bold text-[22px] mt-2">You're a Tutor!</p>
                    </div>
                </div>

                <!-- Right side -->
                <div class="w-full md:w-1/2 flex flex-col justify-center p-3"> 
                    <div class="w-4/5">
                        <form method="POST" action="{{ route('experience.tutor.store') }}"> 
                            @csrf 

                            <!-- Rate per Session -->
                            <div class="mt-4">
                                <x-input-label class="text-primary" for="rate_session" :value="__('Rate per Session:                                ')" />

                                <div class="relative block">
                                    <span class="absolute font-semibold flex items-center left-2 top-1/2 transform pl-[2px] -translate-y-1/2 text-gray-500"> ₱ |</span>
                                    <x-text-input id="course_name" class="pl-8  block mt-1 w-full" type="number" name="rate_session" 
                                    placeholder="   Rate per Session" :value="old('rate_session')" required  />
                                </div>
                                <x-input-error :messages="$errors->get('rate_session')" class="mt-2" />
                            </div>


                            <!-- Year of Experiences -->
                            <div class="mt-4">
                            <x-input-label class="text-primary" for="exp" :value="__('Experience:')" />
                                <select name="exp" class="border-2 font-poppins border-black p-3 rounded shadow-custom-button shadow-black w-full">
                                    <option value="" disabled selected>Years of Experience</option>
                                    <option value="None">None</option>
                                    <option value="1 - 5 sessions completed">1 - 5 sessions completed</option>
                                    <option value="5 - 10 sessions completed">5 - 10 sessions completed</option>
                                    <option value="10+ sessions completed">10+ sessions completed</option>
                                </select>
                            </div>

                            <!-- Payment Methods -->
                            <div class="mt-4">
                                <x-input-label class="text-primary" for="gcash" :value="__('GCash (Required):')" />
                                <x-text-input id="gcash" class="block mt-1 w-full" type="text" name="gcash" 
                                placeholder="Enter your GCash number" :value="old('gcash')" required />
                                <x-input-error :messages="$errors->get('gcash')" class="mt-2" />

                                <x-input-label class="text-primary mt-4" for="grabpay" :value="__('GrabPay:')" />
                                <x-text-input id="grabpay" class="block mt-1 w-full" type="text" name="grabpay" 
                                placeholder="Enter your GrabPay account" :value="old('grabpay')" />
                                <x-input-error :messages="$errors->get('grabpay')" class="mt-2" />

                                <x-input-label class="text-primary mt-4" for="maya" :value="__('Maya:')" />
                                <x-text-input id="maya" class="block mt-1 w-full" type="text" name="maya" 
                                placeholder="Enter your Maya account" :value="old('maya')" />
                                <x-input-error :messages="$errors->get('maya')" class="mt-2" />
                            </div>
    
                           
                           <div class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                                <x-primary-button onclick="history.back()" type="button" class="font-bold font-poppins bg-gray-300 text-black">
                                    {{__('Back')}}
                                </x-primary-button>
                                
                                <div>
                                <x-primary-button class="font-bold font-poppins">
                                    {{__('Next')}}
                                </x-primary-button>
                            </div>
    
                            </form> 
                    </div>
                </div>
            </div>
                
        </x-slot>    
    </x-folder>
</x-auth-layout>
