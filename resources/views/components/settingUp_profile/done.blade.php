<x-auth-layout>
    <x-folder>
        <x-slot name="header">
            Done setting up profile
        </x-slot>    
        <x-slot name="content">
            <p>successfully setting up profile</p>
            <p>for {{Auth::user()->name}}</p>
        </x-slot>
    </x-folder>
</x-auth-layout>