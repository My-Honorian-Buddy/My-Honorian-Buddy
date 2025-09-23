<x-profile-layout>
    <x-slot name="sidebars">
        <!-- Sidebar Content -->
        <x-profile.tutor-sidebar />

    </x-slot>
    
    <x-slot name="maincontent">
        <div class="m-8">
            <!-- Page 2 -->
                <!-- Profile Information Card -->
                <x-profile.card-profile-info-student/>

                <!-- Sujects Table Card -->
                <x-profile.card-subjects-table />

                <!-- Date Availability Card -->
                <x-profile.card-date-availability />
            
        </div>
    </x-slot>
</x-profile-layout>