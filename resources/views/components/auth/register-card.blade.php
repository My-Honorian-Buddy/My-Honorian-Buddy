<div class="flex flex-col overflow-hidden justify-center items-center border-primary/20 md:flex-row h-screen bg-primary border rounded-[16px] shadow-2xl w-4/5 my-24 mx-auto">
    <div class="md:w-1/2 w-full bg-primary h-full font-poppins rounded-[16px]">
        <div class="flex justify-start items-center h-1/6 w-full lg:w-full md:w-full sm:w-full sm:shrink-0">
            <img src="{{ asset('images/logo-light.png') }}" alt="logo" class="m-[5%] lg:w-1/6 xl:w-1/5">
        </div>
        <center><img src="{{ asset('/images/auth/register.svg') }}" class="lg:h-[350px] xl:h-[400px] lg:w-[350px] xl:w-[400px]" alt="Register Photo" ></center>
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
    <div class=" flex flex-col justify-center md:w-1/2 w-full bg-accent3 p-10 px-20 h-full">
            
        <h2 class=" text-black lg:text-4xl xl:text-5xl mb-6 font-bold font-poppins"> Create Account </h2>
        <div class="w-full">
            {{ $slot }}
        </div>
            
        
    </div>
</div>
