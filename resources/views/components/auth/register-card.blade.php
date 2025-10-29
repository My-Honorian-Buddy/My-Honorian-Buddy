<div class="overflow-hidden flex flex-col lg:flex-row bg-secondary border-4 border-charcoal rounded-md w-full max-w-7xl mx-auto">
    <!-- Left Side - Illustration -->
    <div class="hidden lg:flex flex-col w-full lg:w-1/2 bg-primary font-poppins p-6 sm:p-8 lg:p-10">
        <div class="flex justify-start items-center mb-8 lg:mb-0 lg:h-1/6">
            <img src="{{ asset('images/logo-light.png') }}" alt="logo" class="w-16 sm:w-20 lg:w-24 xl:w-28">
        </div>
        <div class="flex flex-col justify-center items-center flex-1">
            <img src="{{ asset('/images/auth/register.svg') }}" class="w-full max-w-[300px] lg:max-w-[350px] xl:max-w-[400px] mb-6" alt="Register illustration">
            <x-auth.description-text>
                <x-slot name="title">
                    Start Your Learning Journey
                </x-slot>
                <x-slot name="paragraph">
                    Join our community today! Create your account and connect with tutors or students.
                    Your path to academic success begins here.
                </x-slot>
            </x-auth.description-text>
        </div>
    </div>
    
    <!-- Right Side - Form -->
    <div class="flex flex-col justify-center w-full lg:w-1/2 lg:bg-accent3 p-6 sm:p-8 md:p-12 lg:p-16 xl:px-20 min-h-[400px] lg:min-h-[600px]">
        <h2 class="font-dela text-charcoal text-2xl sm:text-3xl md:text-4xl lg:text-5xl mb-4 sm:mb-6 font-bold leading-tight">
            Create Account
        </h2>
        <div class="w-full">
            {{ $slot }}
        </div>
    </div>
</div>
