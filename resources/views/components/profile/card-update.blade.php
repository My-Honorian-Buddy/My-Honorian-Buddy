<div class="flex mt-8 mb-8">
    <div class="w-full bg-gray-300 h-auto pb-16 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">

            <!-- Card Content -->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-bold text-4xl m-5 leading-relaxed">Update Password</span>
                <span class="font-bold text-red-900 text-1xl ml-5 mb-5">Ensure your account is using a long, random password to stay secure.</span>
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
                <div class="flex items-center justify-end m-8">
                    <x-primary-button type="submit" class="bg-red-900 text-white">Save</x-primary-button>
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