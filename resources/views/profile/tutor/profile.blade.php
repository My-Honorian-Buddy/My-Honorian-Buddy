<x-profile-layout>
    <x-slot name="sidebars">
        <!-- Sidebar Content -->
        <x-profile.tutor-sidebar />

    </x-slot>
    
    <x-slot name="maincontent">
        <div class="m-8">

            <!-- Profile Card -->
            <x-profile.card-profile />
            
            <!-- Subject Card -->
            <x-profile.card-subjects />

            <!-- Date Card -->
            <x-profile.card-date />
        </div>
    </x-slot>
</x-profile-layout>