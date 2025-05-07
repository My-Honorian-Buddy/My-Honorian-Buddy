<x-workspace-layout>
    <x-slot name="sidebar_content">
        <!-- Sidebar Content -->
        <x-profile.tutor-sidebar />

    </x-slot>
    
    <x-slot name="main_content">
        <div class="m-8">

            <!-- Profile Card -->
            <x-profile.card-profile />
            
            <!-- Subject Card -->
            <x-profile.card-subjects />

            <!-- Date Card -->
            <x-profile.card-date />
        </div>
    </x-slot>
</x-workspace-layout>