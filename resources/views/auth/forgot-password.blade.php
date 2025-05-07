<x-auth-layout>
    <x-folder class="h-full">
        <x-slot name="header">
            Find Your Account
        </x-slot>

        <x-slot name="content" class="h-full bg-green-600">
            <div class="flex w-full h-full">
                <div class="w-full flex flex-col items-center justify-center">

                    <!-- Title and Paragraph -->
                    <div class=" w-full flex flex-col items-center justify-start text-primary">
                        
                        <div class="w-4/5">
                        <h2 class="text-black font-poppins text-[64px] text-pretty leading-[64px] font-semibold text-left">
                            Forgot Password?
                            No Problem.
                        </h2>
                        <p class="font-poppins text-[16px] text-pretty font-semibold text-left pt-5">
                            Just let us know you email address and we will email you a password reset link
                            that will allow to choose new one.
                        </p>
                        </div>
                    </div>
                    
                    <div class="w-4/5 pt-4">
                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <form method="POST" action="{{ route('password.email') }}" ">
                            @csrf
                            
                            <!-- Email Address -->
                                <div class="w-full ">
                                    
                                    <x-text-input id="email" placeholder="Enter your email..." class="mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="w-fulln flex items-center justify-end">
                                    <div>
                                        <x-primary-button class="mt-4 md:w-auto font-bold font-poppins text-sm sm:text-base md:text-lg lg:text-lg text-left flex flex-wrap items-center gap-1 ml-[-4px] sm:ml-0">
                                            {{ __('Email Password Reset Link') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
          

            <!-- Picture -->
            <div class=" flex w-4/5 items-center justify-center">
            <center><img class="-auto max-w-full h-[400px] w-[400px]" src="{{ asset('/images/auth/forgot-password.svg') }}" alt="external photo" ></center>
            </div>
          
            </div> 
    </x-slot>

</x-auth-layout>
</x-folder>
