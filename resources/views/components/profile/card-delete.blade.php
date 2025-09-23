<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent3 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">

            <!-- Card Content -->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-bold text-4xl m-5 leading-relaxed">Delete Account:</span>
                <span class="font-bold text-red-900 text-1xl ml-5 mb-5">Once your account is deleted, all of its resouces and data will be permanently deleted. 
                                                                            Before deleting your account, please download any data or information that you wish to retain.</span>
            </div>

                <!-- Button-->
                <div class="flex justify-end m-8">
                    <x-danger-button 
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    type="submit" 
                    class=" bg-red-900 h-11 rounded-[4px] text-lg  shadow-custom-button text-black ">
                        Delete Account
                    </x-danger-button>
                </div>
                <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')
            
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Are you sure you want to delete your account?') }}
                        </h2>
            
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </p>
            
                        <div class="mt-6">
                            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
            
                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                class="mt-1 block w-3/4"
                                placeholder="{{ __('Password') }}"
                            />
            
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>
            
                        <div class="mt-6 flex justify-between ">
            
                            <p class="mt-1 text-sm text-gray-600">
                                {!! __('Note: If you logged in using your Google Account, <br>you do not need to enter your password to delete.') !!}
                            </p>
            
                            <div>
                                <x-secondary-button class="bg-accent2" x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>
            
                                <x-danger-button class="ms-3">
                                    {{ __('Delete Account') }}
                                </x-danger-button>
                            </div>
                        </div>
                    </form>
                </x-modal>
        </div>
    </div>
</div>