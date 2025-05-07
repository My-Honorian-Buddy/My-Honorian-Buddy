<x-workspace-layout>
    <x-slot name="sidebar_content">
        <!-- Sidebar Content -->
        <x-profile.tutor-sidebar />

    </x-slot>
    
    <x-slot name="main_content">
        <div class="m-8">
            <!-- Update Card -->
            <x-profile.card-update />

            <!-- Delete Card -->
            <x-profile.card-delete />
            
            
        </div>
    </x-slot>
</x-workspace-layout>