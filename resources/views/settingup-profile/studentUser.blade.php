<x-auth-layout>
    <x-folder class="min-h-screen flex flex-col">
        <x-slot name="header">
            Tell us more! 
        </x-slot>
        
        <x-slot name="content">
            <div class="text-center font-bold text-6xl my-8">
                Who are you?
            </div>

            <div class="flex flex-col pb-44 md:flex-row md:space-x-6 sm:pb-64 lg:pb-20">
                <!-- Left side -->
                <div class="w-auto md:w-1/2 flex justify-center mt-6 md:mt-0">
                    <div class="flex flex-col px-4 justify-center">
                        <img src="{{ asset('/images/profiling/Student.svg') }}" alt="placeholder" class="ml-[20px] max-w-full h-auto -mt-8">
                        <p class="text-center font-poppins font-bold text-[22px] mt-2">You're a Student!</p>
                    </div>
                </div>

                <!-- Right side -->
                <div class="w-full md:w-1/2 flex flex-col justify-center p-3"> 
                    <div class="w-4/5">
                        <form method="POST" action="{{ route('profile.student.store') }}"> 
                            @csrf

                            <div class="flex flex-col lg:flex-row gap-4">
                                <!-- First Name -->
                                <div class="mt-4 w-full">
                                    <x-input-label class="text-primary" for="first_name" :value="__('First Name:')" />
                                    <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" placeholder="First Name..." :value="old('first_name')" required  />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>
                                
                                <!-- Last Name -->
                                <div class="lg:mt-4 w-full">
                                    <x-input-label class="text-primary" for="last_name" :value="__('Last Name:')" />
                                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" placeholder="Last Name..." :value="old('last_name')" required />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>
                            
                            <!-- Gender -->
                            <div class="mt-4">
                                <x-input-label class="text-primary" for="gend" :value="__('Gender:')" />
                                <x-gender-selection />
                            </div>

                            <div class="flex flex-col lg:flex-row gap-4 mt-2">
                                <!-- Address  -->
                                <div class="w-full">
                                    <x-input-label class="text-primary" for="address" :value="__('Address:')" />
                                    <x-text-input id="Birthday" class="block mt-1 w-full" type="text" name="add" placeholder="Address..." :value="old('add')" required  />
                                    <x-input-error :messages="$errors->get('add')" class="mt-2" />
                                </div>
                                
                                <!-- Date of Birth -->
                                <div class="w-full">
                                    <x-input-label class="text-primary" for="Birthday" :value="__('Date of Birth:')" />
                                    <x-text-input id="Birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" required />
                                    <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Bio -->
                            <div class="mt-4">
                                <label class="font-poppins block text-lg text-primary font-bold mt-4"> Bio: <span class="font-normal"> (optional) </span> </label>
                                <textarea id="bio" name="bio_student" class="block mt-1 w-full border-black border-[3px] rounded-[4px] focus:border-indigo-500 focus:ring-indigo-500 font-poppins shadow-custom-button px-4 py-2" placeholder="Brief introduction of yourself..."></textarea>
                            </div>
    
                           <!-- Buttons -->
                           <div class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                            
                                <x-primary-button onclick="history.back()" class="font-bold font-poppins bg-primary text-accent2 w-full sm:w-auto">
                                    {{__('Back')}}
                                </x-primary-button>
                                
                                <div>
                                <x-primary-button class="bg-primary text-accent2 font-bold font-poppins w-full sm:w-auto">
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
