<div class="flex-1">

    <!-- Sidebar -->

    <div class="flex flex-col md:flex-row" x-data="{ isOpen: false }">
        

        {{-- Main Content --}}
        <div class="w-full lg:flex-1">
            <div class="m-8">

                {{ $maincontent }}
            </div>
        </div>

    </div>
</div>

<script>
    // Burger menu toggle - wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        const tham = document.querySelector(".tham");

        if (tham) {
            tham.addEventListener('tham-active', () => {
                tham.classList.toggle('click');
                tham.style.setProperty('--animate-duration', '0.5s');
            });
        }
    });
</script>
