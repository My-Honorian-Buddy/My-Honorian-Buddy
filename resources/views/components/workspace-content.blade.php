
<div class="flex-1">

    <!-- Sidebar --> 
    
    <div class="flex" x-data="{ isOpen: false }">
    <div class="w-96 min-h-screen p-8 space-y-6 border-r border-black" :class="{ 'w-96 animate__animated animate__fadeInLeft animate__faster': isOpen, 'hidden': !isOpen }">
            {{ $sidebars }}
        </div>
        
        {{-- Main Content --}}
        <div :class="{ 'w-full ': !isOpen, 'flex-1': isOpen } ">
            <div class=" m-8">
                <!-- Burger -->
                    <div  class="burger" @click.prevent="isOpen = !isOpen">
                        <div class="tham tham-e-squeeze tham-w-6">
                            <div class="tham-box mb-8">
                                <div class="tham-inner"></div>
                            </div>
                        </div>
                    </div>
                    {{ $maincontent }}
            </div>
        </div>  
    </div>
</div>

<script>  
    // Burger
    const tham = document.querySelector(".tham");
        
        tham.addEventListener('tham-active', () => {
        tham.classList.toggle('click');
        tham.style.setProperty('--animate-duration', '0.5s');
        });


</script>             