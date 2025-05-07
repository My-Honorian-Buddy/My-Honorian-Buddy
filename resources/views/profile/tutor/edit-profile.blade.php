<x-workspace-layout>
    <x-slot name="sidebar_content">
        <!-- Sidebar Content -->
        <x-profile.tutor-sidebar />

    </x-slot>
    
    <x-slot name="main_content">
        <div class="m-8">
            <!-- Page 2 -->
                <!-- Profile Information Card -->
                <x-profile.card-profile-info-student/>

                <!-- Sujects Table Card -->
                <x-profile.card-subjects-table />

                <!-- Sujects Table Card -->
                @if (Auth::user() -> role === 'Tutor')
                <!-- Rate Card -->
                <x-profile.card-rate-experience/>
                @endif
                
                <!-- Date Availability Card -->
                <x-profile.card-date-availability />
            
        </div>
    </x-slot>
</x-workspace-layout>