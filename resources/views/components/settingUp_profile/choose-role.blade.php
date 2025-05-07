<x-auth-layout>
    <x-folder>
        <x-slot name="header">
            Choose your Role
        </x-slot>    
        
        <x-slot name="content">
            <div class="flex items-center justify-center gap-3 h-full">
                <div>
                    <form method="POST" action="{{ route('role.store') }}">
                        @csrf
                        <input type="hidden" name="role" value="Student">
                        <x-primary-button class="font-semibold">
                            {{ __('Student') }}
                        </x-primary-button>
                    </form>
                </div>
                <div>                                                                           
                    <form method="POST" action="{{ route('role.store') }}">
                        @csrf
                        <input type="hidden" name="role" value="Tutor">
                        <x-primary-button class="font-semibold">
                            {{ __('Tutor') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </x-slot>
    </x-folder>
</x-auth-layout>