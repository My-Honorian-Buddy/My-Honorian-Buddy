<x-auth-layout>
    <x-folder class="overflow-x-hidden">
        <x-slot name="header">
            Tell us more!
        </x-slot>

        <x-slot name="content">
            <div class="text-center text-charcoal font-bold text-3xl md:text-5xl lg:text-6xl my-6 md:my-8 px-4">
                Who are you?
            </div>

            <div class="flex flex-col pb-20 md:pb-32 lg:pb-20 md:flex-row md:space-x-6 px-4 md:px-6">
                <!-- Left side -->
                <div class="w-full md:w-1/2 flex justify-center mt-6 md:mt-0">
                    <div class="flex flex-col justify-center items-center">
                        <img src="{{ asset('/images/profiling/Tutor.svg') }}" alt="placeholder"
                            class="w-[200px] md:w-[250px] lg:w-auto max-w-full h-auto">
                        <p class="text-center text-charcoal font-poppins font-bold text-lg md:text-xl lg:text-[22px] mt-2">You're a Tutor!</p>
                    </div>
                </div>

                <!-- Right side -->
                <div class="w-full md:w-1/2 flex flex-col justify-center p-3 mt-6 md:mt-0">
                    <div class="w-full lg:w-4/5">
                        <form method="POST" action="{{ route('profile.tutor.store') }}">
                            @csrf

                            <div class="flex flex-col lg:flex-row gap-4">
                                <!-- First Name -->
                                <div class="mt-4 w-full">
                                    <x-input-label class="text-darkgray text-sm md:text-base" for="first_name" :value="__('First Name:')" />
                                    <x-text-input id="first_name"
                                        class="block mt-1 w-full outline-none duration-200 ring-2 focus:ring-primary/70
                                    ring-[transparent] focus:border-primary/70 text-sm md:text-base"
                                        type="text" name="first_name" placeholder="First Name..." :value="old('first_name')"
                                        required />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>

                                <!-- Last Name -->
                                <div class="mt-4 lg:mt-4 w-full">
                                    <x-input-label class="text-darkgray text-sm md:text-base" for="last_name" :value="__('Last Name:')" />
                                    <x-text-input id="last_name"
                                        class="block mt-1 w-full outline-none duration-200 ring-2 focus:ring-primary/70
                                    ring-[transparent] focus:border-primary/70 text-sm md:text-base"
                                        type="text" name="last_name" placeholder="Last Name..." :value="old('last_name')"
                                        required />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="mt-4">
                                <x-input-label class="text-darkgray text-sm md:text-base" for="gend" :value="__('Gender:')" />
                                <x-gender-selection />
                            </div>

                            <div class="flex flex-col lg:flex-row gap-4 mt-2">
                                <!-- Address  -->
                                <div class="w-full mt-2">
                                    <x-input-label class="text-darkgray text-sm md:text-base" for="address" :value="__('Address:')" />
                                    <x-text-input id="address"
                                        class="block mt-1 w-full outline-none duration-200 ring-2 focus:ring-primary/70
                                    ring-[transparent] focus:border-primary/70 text-sm md:text-base"
                                        type="text" name="add" placeholder="Address..." :value="old('add')"
                                        required />
                                    <x-input-error :messages="$errors->get('add')" class="mt-2" />
                                </div>

                                <!-- Date of Birth -->
                                <div class="w-full mt-2">
                                    <x-input-label class="text-darkgray text-sm md:text-base" for="Birthday" :value="__('Date of Birth:')" />
                                    <x-text-input id="Birthday"
                                        class="block mt-1 w-full outline-none duration-200 ring-2 focus:ring-primary/70
                                    ring-[transparent] focus:border-primary/70 text-sm md:text-base"
                                        type="date" name="birthday" :value="old('birthday')" required />
                                    <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="font-poppins block text-darkgray font-bold text-sm md:text-base"> Bio <span
                                        class="font-normal"> <b> (Optional): </b> </span> </label>
                                <textarea id="bio" name="bio_tutor"
                                    class="block mt-1 w-full border-gray-300 border rounded-[4px] outline-none duration-200 ring-2 bg-accent
                                focus:ring-primary/70 ring-[transparent] focus:border-primary/70 font-poppins px-4 py-2 text-sm md:text-base min-h-[100px]"
                                    placeholder="Brief introduction of yourself..."></textarea>
                            </div>


                            <div
                                class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                                <x-primary-button onclick="history.back()" type="button"
                                    class="font-bold font-poppins bg-accent text-primary text-sm md:text-base ring-2 ring-transparent hover:ring-primary/70
                               hover:bg-primary/5 border-black border hover:border-2 hover:border-primary/70 rounded-lg w-full sm:w-auto px-6 py-3">
                                    {{ __('Back') }}
                                </x-primary-button>


                                <x-primary-button
                                    class="bg-primary text-accent3 font-bold font-poppins w-full sm:w-auto text-sm md:text-base
                                    hover:bg-primary/70 rounded-lg px-6 py-3">
                                    {{ __('Next') }}
                                </x-primary-button>

                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </x-slot>
    </x-folder>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const birthdayInput = document.getElementById('Birthday');
            const form = document.querySelector('form');

            function calculateAge(birthDate) {
                const today = new Date();
                const birth = new Date(birthDate);
                let age = today.getFullYear() - birth.getFullYear();
                const monthDiff = today.getMonth() - birth.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                    age--;
                }
                return age;
            }

            function validateAge() {
                if (!birthdayInput.value) return true;

                const age = calculateAge(birthdayInput.value);
                const errorElement = document.getElementById('age-error');

                if (age < 18) {
                    if (!errorElement) {
                        const error = document.createElement('div');
                        error.id = 'age-error';
                        error.className = 'text-red-600 text-sm mt-1';
                        error.textContent = 'You must be at least 18 years old to register.';
                        birthdayInput.parentNode.appendChild(error);
                    }
                    birthdayInput.classList.add('border-red-500');
                    return false;
                } else {
                    if (errorElement) {
                        errorElement.remove();
                    }
                    birthdayInput.classList.remove('border-red-500');
                    return true;
                }
            }

            birthdayInput.addEventListener('change', validateAge);
            birthdayInput.addEventListener('blur', validateAge);

            form.addEventListener('submit', function(event) {
                if (!validateAge()) {
                    event.preventDefault();
                }
            });
        });
    </script>
</x-auth-layout>
