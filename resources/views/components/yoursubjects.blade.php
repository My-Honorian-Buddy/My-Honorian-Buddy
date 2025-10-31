@props(['pickedSubjects', 'user'])
<div data-aos="fade-up" data-aos-anchor-placement="top-bottom"
    class="w-full lg:w-1/2 flex flex-col bg-accent rounded-md overflow-hidden border-charcoal border-2 max-lg:mt-6">
    <div class="flex bg-accent items-center w-full border-charcoal py-2">
        <div
            class="font-dela flex w-full justify-start text-xl text-charcoal font-black ml-8 max-md:ml-4 max-md:text-lg">
            Your Subjects
        </div>
    </div>
    <span class="flex mx-4 items-center">
        <span class="h-px flex-1 bg-charcoal"></span>
    </span>

    @if (!empty($pickedSubjects))
        @foreach ($pickedSubjects as $subject)
            <div
                class="bg-accent flex items-center w-ful py-2 px-8 max-md:flex-col max-md:items-start">
                
                <div class="grid grid-rows-1 my-7 ml-3 max-md:ml-4 max-md:my-4 max-md:w-full">
                    <div>
                        <p class="font-poppins font-bold text-2xl break-words max-md:text-lg">
                            {{ $subject->subj_code }} -
                            <span class="font-semibold text-xl text-primary italic">{{ $subject->subj_name }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>
        @endforeach
    @else
        <div
            class="bg-accent flex flex-1 min-h-0 overflow-y-auto justify-center items-center h-auto w-full py-12 max-md:py-8">
            <div class="flex flex-col w-full items-center justify-center mt-3 mb-2">
                <x-bladewind.icon name="book-open" type="outline"
                    class="!h-24 !w-24 !fill-gray-300 !stroke-gray-500 max-md:!h-16 max-md:!w-16" />
                <div class="flex text-center px-4">
                    <p class="font-bold text-[23px] max-md:text-lg">No Subjects Available</p>
                </div>
            </div>
        </div>
    @endif
</div>
