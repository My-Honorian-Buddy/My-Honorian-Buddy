<x-workspace-layout>
    <x-slot name="sidebar_content">
        <!-- Sidebar Content -->
        <x-profile.tutor-sidebar />

    </x-slot>
    
    <x-slot name="main_content">
        <div class="m-8">
            <!-- Page 1 -->
                <!-- Profile Card -->
                <x-profile.card-profile />

                <!-- Subject Card -->
                <x-profile.card-subjects />

                <!-- Date Card -->
                <x-profile.card-date />

            <!-- Page 2 -->
                <!-- Profile Information Card -->
                <x-profile.card-profile-info-student />

                <!-- Sujects Table Card -->
                <x-profile.card-subjects-table />

                <!-- Date Availability Card -->
                <x-profile.card-date-availability />

            <!-- Page 3 -->
                <!-- Update Card -->
                <x-profile.card-update />

                <!-- Delete Card -->
                <x-profile.card-delete />
            
        </div>
    </x-slot>
</x-workspace-layout>