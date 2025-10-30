<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent h-auto pb-8 rounded-md border-charcoal border-4">
        <div class="relative rounded-[20px] px-8">

            <!-- Card Content -->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-dela font-bold text-4xl m-5 mb-0 leading-relaxed">Update Password</span>
                <span class="italic font-bold text-primary text-1xl ml-5 mb-5">Ensure your account is using a long, random password to stay secure.</span>
            </div>

            <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                @csrf
                @method('put')
                {{-- inputs --}}
                
                <div class="flex justify-center">
                    <div class="w-3/5 flex flex-col space-y-8">
                        {{-- for current password --}}
                        <div>
                            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>
                
                        <div>
                            <x-input-label for="update_password_password" :value="__('New Password')" />
                            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                        </div>
                
                        <div>
                            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Button-->
                <div class="w-auto mt-6 m-8 flex justify-end">
                    <button type="submit"
                        class="sm:w-auto bg-accent px-6 sm:px-8 md:px-10 py-2 sm:py-2.5 md:py-1 h-auto sm:h-10 md:h-11 border-2 border-black
                                active:scale-95 transition-all duration-800 ease-in-out flex items-center justify-center rounded-sm font-bold text-sm
                                hover:bg-primary w-auto hover:text-accent tracking-widest uppercase hover:shadow-custom-button">
                        Save
                    </button>
                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>

        </div>
    </div>
</div>