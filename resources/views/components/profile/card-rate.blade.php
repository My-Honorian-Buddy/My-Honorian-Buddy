<div class="hidden mt-8 mb-8">
    <div class="w-full bg-gray-300 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">

            <!-- Card Content -->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-bold text-4xl m-5 leading-relaxed">Rate per Session & Experience</span>
                <span class="font-semibold text-2xl ml-5 mt-5">P {{Auth::user() -> tutor -> rate_session}}</span>
                <span class="font-semibold text-red-900 text-1xl ml-5">Rate per Session</span>
                <span class="font-semibold text-2xl m-5"> {{Auth::user() -> tutor -> exp}} </span>
                <span class="font-semibold text-red-900 text-1xl ml-5">Experience</span>
            </div>

        </div>
    </div>
</div>