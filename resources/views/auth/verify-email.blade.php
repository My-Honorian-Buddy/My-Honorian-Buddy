<x-auth-layout>
    <x-folder>
        <!-- header with a title -->
        <x-slot name="header">
            Verification Email
        </x-slot>

        <!-- Slot for the content -->
        <x-slot name="content">
            <!-- Container for the content with a flexbox layout to reverse row order on smaller screens -->
            <div class="flex flex-col md:flex-row-reverse mt-4 sm:mt-6 md:mt-[60px] mb-4 md:mb-[80px] px-4 sm:px-6 md:px-8 lg:px-0">
                <!-- Image container aligned at the center with responsive width -->
                <div class="w-full md:w-1/2 flex justify-center items-center mb-6 md:mb-0 md:mt-[-30px] md:mr-[20px]">
                    <!-- Placeholder image with responsive sizing --> 
                    <img src="{{ asset('/images/auth/email-verification.png') }}" 
                         class="w-[180px] sm:w-[220px] md:w-[280px] lg:w-[350px] xl:w-[420px] 2xl:w-[500px] h-auto object-contain" 
                         alt="Email Verification Photo">
                </div>

                <!-- Text container for the verification message -->
                <div class="w-full md:w-1/2 flex flex-col justify-center">
                    <!-- Custom description-text component for displaying the title and paragraph -->
                    <x-auth.description-text>
                        <!-- Slot for the title -->
                        <x-slot name="title">
                            <div class="text-black font-poppins text-xl xs:text-2xl sm:text-3xl md:text-3xl lg:text-4xl xl:text-[55px] text-pretty leading-tight sm:leading-snug md:leading-[1.2] xl:leading-[64px] font-semibold text-center md:text-left px-2 md:px-0">
                                Thank you for <br class="hidden md:inline"> signing up!
                            </div>
                        </x-slot>

                        <!-- Slot for the paragraph -->
                        <x-slot name="paragraph">
                            <p class="font-poppins text-center md:text-left text-xs xs:text-sm sm:text-base md:text-[15px] text-primary/70 font-semibold px-2 sm:px-4 md:px-0 mt-3 md:mt-4">
                                Almost there! Click the button below to receive a
                                verification email and complete your account setup.
                            </p>
                        </x-slot>
                    </x-auth.description-text>

                    <!-- Conditional statement to check if a verification link has been sent -->
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 mt-4 font-medium text-xs sm:text-sm text-green-600 text-center md:text-left md:ml-[95px] px-2 sm:px-4 md:px-0">
                            {{ __('A verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <!-- Container for buttons with responsive margin and layout -->
                    <div class="mt-6 md:mt-4 items-center flex flex-col sm:flex-row gap-3 sm:gap-4 md:gap-0 md:space-x-8 px-2 sm:px-4 md:px-0">
                        <!-- Form to resend verification email -->
                        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                            @csrf
                            <x-primary-button class="bg-primary text-accent3 hover:bg-primary/80 rounded-lg
                            border-gray-700/20 hover:border-primary font-bold w-full sm:w-auto md:ml-[95px] text-sm md:text-base py-2 md:py-3 px-4 md:px-6">
                                {{ __('Send Verification Email') }}
                            </x-primary-button>
                        </form>

                        <!-- Form to log out the user -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                            @csrf
                            <x-primary-button type="submit" class="font-bold text-primary bg-accent 
                            rounded-lg hover:bg-primary/5 w-full sm:w-auto text-sm md:text-base py-2 md:py-3 px-4 md:px-6">
                                {{ __('Log Out') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-folder>
</x-auth-layout>
