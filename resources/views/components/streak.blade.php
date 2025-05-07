<section class="m-4 max-w-xs">
    <!-- container -->
    <div class="bg-accent2 rounded-[20px] pt-2 pb-10 mb-4 shadow-custom-button shadow-black border-black border-2">
        <!-- streak content -->
        <div class="flex justify-center items-center p4">
            <!-- left side column -->
            <div>
                <p class="text-xl font-poppins font-bold text-black mr-6">You have<br> studied for:</p>
                <p class="text-3xl text-accent text-stroke-thick2 font-black">3 days </p>
            </div>
            
            <!-- right side column -->
            <div class=" relative w-24 h-24">
                <!-- progress bar na circle -->
                <div class="absolute inset-0 w-full h-full">
                    <x-bladewind.progress-circle 
                    percentage="75"
                    color="red"
                    shade="dark"
                    size="medium"
                    text_size="0"
                    align="40"
                    valign="0"
                    circle_width="20"
                    show_label="false"
                    animate="false"
                    class="w-full h-full rounded-full"
                    />
                </div>  
            </div>
        </div>    
    </div> 
</section>