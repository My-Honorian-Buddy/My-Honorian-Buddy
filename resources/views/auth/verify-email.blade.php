<!-- PROGRAMMERS: GONZALES, IAN JOSHUA B.
             TRINIDAD, CECIL RIC -->



<x-auth-layout>
    <x-folder>
        <!-- header with a title -->
        <x-slot name="header">
            Verification Email
        </x-slot>

        <!-- Slot for the content -->
        <x-slot name="content">
            <!-- Container for the content with a flexbox layout to reverse row order on smaller screens -->
            <div class="flex flex-col md:flex-row-reverse mt-[60px] mb-[20px]">
                <!-- Image container aligned at the center with responsive width -->
                <div class="w-full md:w-1/2 flex justify-center">
                    <!-- Placeholder image from external source --> 
                    <img src="{{ asset('/images/auth/email-verification.svg') }}" class="h-[500px] w-[500px] mt-[-30px] mr-[20px]" alt="Email Verification Photo">
                </div>

                <!-- Text container for the verification message -->
                <div class="w-full md:w-1/2">
                    <!-- Custom description-text component for displaying the title and paragraph -->
                    <x-auth.description-text>
                        <!-- Slot for the title -->
                        <x-slot name="title">
                            <div class="text-black font-poppins text-[55px] text-pretty leading-[64px] font-semibold text-left">
                                Thank you for <br> signing up!
                            </div>
                        </x-slot>

                        <!-- Slot for the paragraph -->
                        <x-slot name="paragraph">
                            <p class="font-poppins text-left text-[16px] text-primary font-semibold">
                                Before getting started, could you verify your email address
                                by clicking on the link we just emailed to you? If you didn't receive  
                                the email, we will gladly send you another.
                            </p>
                        </x-slot>
                    </x-auth.description-text>

                    <!-- Conditional statement to check if a verification link has been sent -->
                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 mt-4 font-medium text-sm text-green-600 ml-[95px]">
                            {{ __('A verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <!-- Container for buttons with responsive margin and layout -->
                    <div class="mt-4 items-center flex flex-col md:flex-row space-x-8">
                        <!-- Form to resend verification email -->
                        
                        <form method="POST" action="{{ route('verification.send') }}" >
                            @csrf
                            <x-primary-button class="mt-[20px] font-bold ml-[95px] text-black md:mt-3">
                                {{ __('Send Verification Email') }}
                            </x-primary-button>
                        </form>

                        <!-- Form to log out the user -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-primary-button type="submit" class=" font-bold text-black bg-white mt-[20px] md:mt-3">
                                {{ __('Log Out') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-folder>
</x-auth-layout>
