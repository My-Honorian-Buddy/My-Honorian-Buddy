<div class="overflow-hidden flex flex-col justify-center items-center border-black md:flex-row h-screen bg-secondary border-4 rounded-[16px] shadow-custom-button w-4/5 my-24 mx-auto">
    <div class="flex flex-col justify-center md:w-1/2 w-full bg-primary p-10 px-20 h-full">
            
        <h2 class=" text-secondary text-5xl mb-6 [text-shadow:4px_4px_0px_#000000] [-webkit-text-stroke:2px_#000000] font-bold font-poppins">
             Welcome Back! 
        </h2>
        <div class="w-full">
            {{ $slot }}
        </div>

    </div>
    <div class="flex flex-col md:w-1/2 w-full bg-secondary h-full font-poppins rounded-[4px]">
        <div class="flex justify-end items-center h-1/6 w-full lg:w-full md:w-full sm:w-full sm:shrink-0">
                <img src="{{ asset('images/logo.svg') }}" alt="logo" class="m-[5%] w-1/5">
        </div>
        <div class="h-[500px] flex flex-col justify-center items-center">
            <center><img src="{{ asset('/images/auth/login.svg') }}" class="h-[400px] w-[400px]" ></center>
            <x-auth.description-text>
                <x-slot name="title">
                    Sign In to Your Learning Journey
                </x-slot>
                <x-slot name="paragraph">
                    Welcome back! Continue where you left off and connect with the right tutor or student.
                    Your next step towards academic success is just a sign-in away.
                </x-slot>
            </x-auth.description-text>
        </div>
        
    </div>
</div>
