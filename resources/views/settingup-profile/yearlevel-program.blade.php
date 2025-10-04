<x-auth-layout>
    <x-folder class="h-full">
        <x-slot name="header">
            <div class="md:text-center justify-center">
                @if(Auth::check())
                    Hello, {{ Auth::user()->name }}!
                @else
                    Hello, Guest!   
                @endif
            </div>
        </x-slot>

        <x-slot name="content">
        
                <div class="text-center font-bold text-5xl mt-8">
                    Choose your Year Level and College Program
                </div>
                
                <!-- Image -->
                <div class="flex flex-col pb-44 md:flex-row md:space-x-6 sm:pb-64 lg:pb-20">
                    <div class="w-auto md:w-1/2 flex justify-center mt-6 md:mt-0">
                        <div class="flex flex-col py-14 px-4 justify-center">
                            <img src="{{ asset('/images/profiling/Student.svg') }}" alt="placeholder" class="ml-[20px] max-w-full h-auto mt-8">
                            <p class="text-center font-poppins font-bold text-[22px] mt-2">You're a Student!</p>
                        </div>
                    </div>
                    
                    <!-- Form --> 
                    <div class="w-full md:w-1/2 flex flex-col justify-center p-3">
                        <div class="w-4/5">
                                <form method="POST" action="{{route('department.student.store')}}">
                                    @csrf
                                    <div class="flex flex-col text-left">
                                        <label class="font-bold font-poppins text-2xl mb-2 ">Year Level:</label>
                                        <select name="year_level" class="border-2 font-poppins border-black p-3 rounded shadow-custom-button shadow-black w-full">
                                            <option value="" disabled selected>Year Level...</option>
                                            <option value="1st Year">1st Year</option>
                                            <option value="2nd Year">2nd Year</option>
                                            <option value="3rd Year">3rd Year</option>
                                            <option value="4th Year">4th Year</option>
                                        </select>

                                        <label class="font-bold font-poppins text-2xl mt-8 mb-2">College Department:</label>
                                        <select class="border-2 font-poppins border-black p-3 rounded shadow-custom-button shadow-black w-full" name="college">
                                            <option value=""disabled selected>College Department...</option>
                                            <option value="College Of Computing Studies">College Of Computing Studies</option>
                                            <option value="College of Education">College of Education</option>
                                            <option value="College of Engineering and Architecture">College of Engineering and Architecture</option>
                                            <option value="College of Arts">College of Arts</option>
                                        </select>

                                        <label class="font-bold font-poppins text-2xl mt-8 mb-2">College Program:</label>
                                        <select class="border-2 font-poppins border-black p-3 rounded shadow-custom-button shadow-black w-full" name="department">
                                            <option value=""disabled selected>College Program...</option>
                                            <option value="Bachelor of Science in Computer Engineering">Bachelor of Science in Computer Engineering</option>
                                            <option value="Bachelor of Science in Computer Science">Bachelor of Science in Computer Science</option>
                                            <option value="Bachelor of Science in Information Systems">Bachelor of Science in Information Systems</option>
                                            <option value="Bachelor of Science in Information Technology">Bachelor of Science in Information Technology</option>
                                        </select>

                                        <div class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                                            <x-primary-button onclick="history.back()" type="button" class="bg-gray-300 text-black-800 font-bold w-full max-w-[120px]">
                                                {{ __('Back') }}
                                            </x-primary-button>
                                            <x-primary-button class="text-black-800 font-bold w-full max-w-[120px] ml-8">
                                                {{ __('Next') }}
                                            </x-primary-button>
                                        </div>
                                    </form>    
                                </div>
                        </div>
                    </div>
                </div>
        </x-slot>
        
    </x-folder>
</x-auth-layout>