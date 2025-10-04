<x-auth-layout>
    <x-folder>
        <!-- header with a title -->
        <x-slot name="header">
            COR Verification
        </x-slot>

        <!-- Slot for the content -->
        <x-slot name="content">
            {{-- Toast? for cor status --}}
            @if (session('status'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 font-semibold shadow-md">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 text-red-800 font-semibold shadow-md">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Container for the content with a flexbox layout to reverse row order on smaller screens -->
            <div class="flex flex-col md:flex-row-reverse mt-[60px] mb-[20px]">
                <!-- Image container aligned at the center with responsive width -->
                <div class="w-full md:w-1/2 flex justify-center">
                    <!-- Placeholder image from external source --> 
                    <img src="{{ asset('/images/auth/email-verification.svg') }}" class="h-[400px] w-[400px] mt-[-30px] mr-[20px]" alt="Email Verification Photo">
                </div>

                <!-- Text container for the verification message -->
                <div class="w-full md:w-1/2">
                    <!-- Custom description-text component for displaying the title and paragraph -->
                    <x-auth.description-text>
                        <!-- Slot for the title -->
                        <x-slot name="title">
                            <div class="text-black font-poppins text-[55px] text-pretty leading-[54px] font-semibold text-left">
                                Thank you for signing up!
                            </div>
                        </x-slot>

                        <!-- Slot for the paragraph -->
                        <x-slot name="paragraph">
                            <p class="font-poppins text-left text-[15px] pt-0 text-primary font-semibold">
                                Before proceding to the next step, please upload your Certificate of Registration (COR)
                                in order to verify that you are a bon afide student of Pampanga State University.
                            </p>
                        </x-slot>
                    </x-auth.description-text>

                    <!-- Container for buttons with responsive margin and layout -->
                    <div class="mt-4 pb-16 items-end flex flex-col md:flex-row space-x-8">
                        
                        <!-- Form to updload cor -->
                        <form method="POST" action="{{ route('cor.upload') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="ml-[95px]">
                                <input type="file" name="cor_pdf" accept=".pdf" required
                                    class="mb-4 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />
                                <button class="w-auto text-primary font-bold bg-accent2 px-10 py-1 h-11 rounded-[4px] text-lg border-2 border-black shadow-custom-button
                                        transition-all duration-600 ease-in-out hover:scale-101 hover:bg-primary hover:text-accent2">
                                    {{ __('Upload COR') }}
                                </button>
                            </div>
                        </form>

                        <!-- Form to log out the user -->
                        <a href="{{ route('workspace.start') }}" class=" justify-items-end">
                            @csrf
                            <button type="submit" class="w-auto text-accent2 font-bold bg-primary px-10 py-1 h-11 rounded-[4px] text-lg border-2 border-black shadow-custom-button
                                        transition-all duration-600 ease-in-out hover:scale-101 hover:bg-accent2 hover:text-primary">
                                {{ __('Workspace') }}
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-folder>
</x-auth-layout>