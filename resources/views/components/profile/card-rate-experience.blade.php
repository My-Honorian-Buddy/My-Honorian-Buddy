@php
    $user = auth()->user()->tutor;
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-gray-300 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">

            <!-- Card Content -->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-bold text-4xl m-5 leading-relaxed">Rate per Session & Experience</span>
            </div>

            <form action="">
                {{-- inputs --}}
                <div class="flex justify-center">
                    <section class="grid grid-rows-2">
                        <span class="font-bold text-red-900 text-1xl mt-5">Update your year rate per session and your years of experience.</span>
                        {{-- for rate per session --}}
                        <span class="font-semibold text-2xl mt-4">Rate per Session</span>
                        <input type="text" placeholder="rate per session" value="{{$user->rate_session}}">

                        {{-- for experience --}}
                        <span class="font-semibold text-2xl mt-5">Experience</span>
                        <input type="text" placeholder="experience" value="{{$user->exp}}">
                    </section>
                </div>

                <!-- Button-->
                <div class="flex justify-end m-8">
                    <x-primary-button type="submit" class="">Save</x-primary-button>
                </div>
            </form>

        </div>
    </div>
</div>