<x-auth-layout>
    <x-folder class="h-auto md:h-full">
        <x-slot name="header" class="text-center">
            <div class="text-center">
                @if (Auth::check())
                    @php
                        $user = Auth::user();
                        $firstName = '';

                        if ($user->role === 'Student' && $user->student) {
                            $firstName = $user->Student->fname;
                        } elseif ($user->role === 'Tutor' && $user->tutor) {
                            $firstName = $user->Tutor->fname;
                        }
                    @endphp
                    Hello, {{ $firstName ?: 'User' }}!
                @else
                    Hello, Guest!
                @endif
            </div>
        </x-slot>

        <x-slot name="content">
            <!--HEADER-->
            <div class="text-center font-bold text-3xl md:text-5xl lg:text-6xl my-6 md:my-8 px-4">
                Choose your Availability Date
            </div>

            <!--CONTAINER-->
            <div class="flex flex-col pb-20 md:pb-32 lg:pb-20 md:flex-row md:space-x-6 px-4 md:px-6">

                <!--IMAGE-->
                <div class="w-full md:w-1/2 flex justify-center mt-6 md:mt-0">
                    <div class="flex flex-col justify-center items-center">
                        @if (Auth::check())
                            @if (Auth::user()->role === 'Student')
                                <img src="{{ asset('/images/profiling/Student.svg') }}" alt="placeholder"
                                    class="w-[200px] md:w-[250px] lg:w-auto max-w-full h-auto">
                                <p class="text-center font-poppins font-bold text-lg md:text-xl lg:text-[22px] mt-2">
                                    You're a Student!</p>
                            @elseif(Auth::user()->role === 'Tutor')
                                <img src="{{ asset('/images/profiling/Tutor.svg') }}" alt="placeholder"
                                    class="w-[200px] md:w-[250px] lg:w-auto max-w-full h-auto">
                                <p class="text-center font-poppins font-bold text-lg md:text-xl lg:text-[22px] mt-2">
                                    You're a Tutor!</p>
                            @endif
                        @endif
                    </div>
                </div>

                <!--FORM-->
                <div class="w-full md:w-1/2 flex flex-col justify-center p-3 mt-6 md:mt-0">
                    <div class="w-full lg:w-4/5">
                        <form method="POST" action="{{ route('user.schedule.store') }}">
                            @csrf

                            <!-- Days -->
                            <label for="Day"
                                class="font-bold font-poppins text-lg md:text-xl lg:text-2xl">Days</label>

                            <div class="py-3">
                                <div class="font-poppins text-black">
                                    <h3 class="text-base md:text-lg font-bold font-poppins text-black mb-1">Weekdays:
                                    </h3>

                                    <div class="flex flex-col md:flex-row md:space-x-2 gap-2 mb-2">
                                        <!-- Monday-->
                                        <div
                                            class="bg-accent py-[6px] rounded-full border-2 border-gray-300 hover:bg-primary/5 duration-200
                                        hover:border-primary/70 text-primary text-sm md:text-[16px] text-center font-bold cursor-pointer w-full md:w-auto">
                                            <label class="w-full h-full cursor-pointer flex items-center px-3">
                                                <input type="checkbox" class="hidden peer" name="days_week[]"
                                                    id="monday" value="Monday">
                                                <span
                                                    class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                                <span class="flex-1 ml-2 text-center">Monday</span>
                                            </label>
                                        </div>

                                        <!-- Tuesday-->
                                        <div
                                            class="bg-accent py-[6px] rounded-full border-2 border-gray-300 hover:bg-primary/5 duration-200
                                        hover:border-primary/70 text-primary text-sm md:text-[16px] text-center font-bold cursor-pointer w-full md:w-auto">
                                            <label class="w-full h-full cursor-pointer flex items-center px-3">
                                                <input type="checkbox" class="hidden peer" name="days_week[]"
                                                    id="Tuesday" value="Tuesday">
                                                <span
                                                    class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                                <span class="flex-1 ml-2 text-center">Tuesday</span>
                                            </label>
                                        </div>

                                        <!-- Wednesday-->
                                        <div
                                            class="bg-accent py-[6px] rounded-full border-2 border-gray-300 hover:bg-primary/5 duration-200
                                        hover:border-primary/70 text-primary text-sm md:text-[16px] text-center font-bold cursor-pointer w-full md:w-auto">
                                            <label class="w-full h-full cursor-pointer flex items-center px-3">
                                                <input type="checkbox" class="hidden peer" name="days_week[]"
                                                    id="Wednesday" value="Wednesday">
                                                <span
                                                    class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                                <span class="flex-1 ml-2 text-center">Wednesday</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Thursday and Friday-->
                                    <div class="flex flex-col md:flex-row md:space-x-2 gap-2 mb-2">
                                        <!-- Thursday-->
                                        <div
                                            class="bg-accent py-[6px] rounded-full border-2 border-gray-300 hover:bg-primary/5 duration-200
                                        hover:border-primary/70 text-primary text-sm md:text-[16px] text-center font-bold cursor-pointer w-full md:w-auto">
                                            <label class="w-full h-full cursor-pointer flex items-center px-3">
                                                <input type="checkbox" class="hidden peer" name="days_week[]"
                                                    id="thursday" value="Thursday">
                                                <span
                                                    class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                                <span class="flex-1 ml-2 text-center">Thursday</span>
                                            </label>
                                        </div>

                                        <!-- Friday-->
                                        <div
                                            class="bg-accent py-[6px] rounded-full border-2 border-gray-300 hover:bg-primary/5 duration-200
                                        hover:border-primary/70 text-primary text-sm md:text-[16px] text-center font-bold cursor-pointer w-full md:w-auto">
                                            <label class="w-full h-full cursor-pointer flex items-center px-3">
                                                <input type="checkbox" class="hidden peer" name="days_week[]"
                                                    id="friday" value="Friday">
                                                <span
                                                    class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                                <span class="flex-1 ml-2 text-center">Friday</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="py-3">
                                <div class="font-poppins text-black">
                                    <h3 class="text-base md:text-lg font-bold font-poppins text-black mb-1">Weekends:
                                    </h3>

                                    <div class="flex flex-col md:flex-row md:space-x-2 gap-2 mb-2">
                                        <!-- Saturday-->
                                        <div
                                            class="bg-accent py-[6px] rounded-full border-2 border-gray-300 hover:bg-primary/5 duration-200
                                        hover:border-primary/70 text-primary text-sm md:text-[16px] text-center font-bold cursor-pointer w-full md:w-auto">
                                            <label class="w-full h-full cursor-pointer flex items-center px-3">
                                                <input type="checkbox" class="hidden peer" name="days_week[]"
                                                    id="saturday" value="Saturday">
                                                <span
                                                    class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary
                                                 peer-checked:border-primary transition-colors duration-200"></span>
                                                <span class="font-poppins ml-2 flex-1 text-center">Saturday</span>
                                            </label>
                                        </div>

                                        <!-- Sunday-->
                                        <div
                                            class="bg-accent py-[6px] rounded-full border-2 border-gray-300 hover:bg-primary/5 duration-200
                                        hover:border-primary/70 text-primary text-sm md:text-[16px] text-center font-bold cursor-pointer w-full md:w-auto">
                                            <label class="w-full h-full cursor-pointer flex items-center px-3">
                                                <input type="checkbox" class="hidden peer" name="days_week[]"
                                                    id="sunday" value="Sunday">
                                                <span
                                                    class="w-5 h-5 bg-gray-300 border-2 border-black rounded-full peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                                <span class="font-poppins ml-2 flex-1 text-center">Sunday</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="flex flex-col">
                                <!-- TIME -->
                                <div class="flex flex-col w-full mb-10 md:mb-20 mt-6 md:mt-10">
                                    <label for="time-from"
                                        class="font-bold font-poppins text-lg md:text-xl lg:text-2xl mb-2">Time</label>
                                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                                        <!-- THIS IS FOR START TIME -->
                                        <div class="w-full">
                                            <label for="start_time"
                                                class="font-poppins font-bold text-sm md:text-base">Start Time:</label>
                                            <input type="time" id="start_time" name="start_time"
                                                class="border-2 font-semibold font-poppins text-xl md:text-2xl text-darkgray text-center rounded-lg border-gray-300
                                                bg-accent outline-none duration-200 ring-2 ring-[transparent] focus:ring-primary/70 w-full h-12 px-2"
                                                required>
                                        </div>

                                        <!-- THIS IS FOR END TIME -->
                                        <div class="w-full flex flex-col justify-start">
                                            <label for="end_time"
                                                class="font-poppins font-bold text-sm md:text-base">End Time:</label>
                                            <input type="time" id="end_time" name="end_time"
                                                class="border-2 font-semibold font-poppins text-xl md:text-2xl text-darkgray text-center rounded-lg border-gray-300
                                                bg-accent outline-none duration-200 ring-2 ring-[transparent] focus:ring-primary/70 w-full h-12 px-2"
                                                required>
                                        </div>
                                    </div>

                                    <div
                                        class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                                        <x-primary-button onclick="history.back()" type="button"
                                            class="font-bold font-poppins bg-accent text-primary text-sm md:text-base ring-2 ring-transparent
                                        hover:bg-primary/5 border-gray-300 border hover:ring-primary/70 hover:border-primary/70 rounded-lg w-full sm:w-auto px-6 py-3">
                                            {{ __('Back') }}
                                        </x-primary-button>
                                        <x-primary-button
                                            class="bg-primary text-accent3 font-bold font-poppins w-full sm:w-auto text-sm md:text-base
                                        hover:bg-primary/70 rounded-lg px-6 py-3">
                                            {{ __('Next') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </x-slot>
    </x-folder>
</x-auth-layout>
