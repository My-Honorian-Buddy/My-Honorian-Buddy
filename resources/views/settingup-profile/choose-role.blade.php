<x-auth-layout>
    <x-folder>
        <x-slot name="header">
                @if(Auth::check())
                    Hello, {{ Auth::user()->name }}!
                @else
                    Hello, Guest!   
                @endif
        </x-slot>    
        
        <x-slot name="content">
            <div class="h-full w-full pb-20">
                <div class="text-black font-poppins font-bold text-[30px] md:text-[50px] text-center mt-10 mb-3">
                    Choose your role:
                </div>
                <form method="POST" action="{{ route('role.store') }}">
                    @csrf
                    <!-- roles -->
                    <div class=" flex flex-col md:flex-row justify-center place-content-center gap-y-8 md:gap-x-28 px-10 py-5">
                        <!-- tutor role -->
                        <label class="flex flex-col items-center"> 
                            <input type="radio" name="role" value="Tutor" class="peer" style="display:none">
                            <img src="{{ asset('/images/profiling/Tutor.svg') }}" alt="placeholder" class="ml-[30px] w-auto h-auto rounded-[30px] cursor-pointer hover:scale-105 ease-in-out duration-300 p-2 border-8 border-transparent peer-checked:bg-accent2 peer-checked:p-2 peer-checked:border-8 peer-checked:border-primary peer-checked:scale-105"> 
                            <p class="text-center font-poppins font-bold text-[22px] mt-2 ml-[10px]">Tutor</p>
                        </label>

                        <!-- student role -->
                        <label class="flex flex-col items-center">
                            <input type="radio" name="role" value="Student" class="peer" style="display:none">
                            <img src="{{ asset('/images/profiling/Student.svg') }}" alt="placeholder" class="ml-[30px] w-auto h-auto rounded-[30px] cursor-pointer hover:scale-105 ease-in-out duration-300 p-2 border-8 border-transparent peer-checked:bg-accent2 peer-checked:p-2 peer-checked:border-8 peer-checked:border-primary peer-checked:scale-105">
                            <p class="text-center font-poppins font-bold text-[22px] mt-2 ml-[10px]">Student</p>
                        </label>
                    </div>

                    <!-- button for next --> 
                    <div class="flex justify-end mr-16 mt-4">
                        <x-primary-button class="font-bold">
                            {{ __('Next') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-slot>
    </x-folder>
</x-auth-layout>