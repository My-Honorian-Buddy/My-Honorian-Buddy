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

                
                           
                           <div class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                                <x-primary-button onclick="history.back()" type="button" class="font-bold font-poppins bg-primary text-accent2">
                                    {{__('Back')}}
                                </x-primary-button>
                                
                                <div>
                                <x-primary-button class="font-bold font-poppins bg-accent2 text-primary">
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
