<x-profile-layout>
    <x-slot name="sidebars">
        <!-- Sidebar Content -->
        <x-profile.tutor-sidebar />

    </x-slot>
    
    <x-slot name="maincontent">
        <div class="m-8">
            <!-- Update Card -->
            <x-profile.card-update />

            <!-- Delete Card -->
            <x-profile.card-delete />

        </div>
    </x-slot>
</x-profile-layout>