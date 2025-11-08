@props(['pickedSubjects', 'user'])
<div 
    class="w-full flex flex-col bg-accent rounded-md overflow-hidden border-charcoal border-2 md:max-lg:w-full sm:w-full">
    <div class="flex bg-accent items-center w-full border-charcoal py-2">
        <div
            class="font-dela flex w-full justify-start text-xl text-charcoal font-black ml-8 max-md:ml-4 max-md:text-base max-sm:text-sm">
            Your Subjects
        </div>
    </div>
    <span class="flex mx-4 items-center">
        <span class="h-px flex-1 bg-charcoal"></span>
    </span>

    @if (!empty($pickedSubjects))
        @foreach ($pickedSubjects as $subject)
            <div
                class="bg-accent flex items-center w-full py-2 px-8 max-md:flex-col max-md:items-start max-md:px-4 max-sm:px-2">
                
                <div class="grid grid-rows-1 my-7 ml-3 max-md:ml-4 max-md:my-4 max-md:w-full max-sm:ml-2 max-sm:my-3">
                    <div>
                        <p class="font-poppins font-bold text-2xl break-words max-md:text-lg max-sm:text-base">
                            {{ $subject->subj_code }} -
                            <span class="font-semibold text-xl text-primary italic max-md:text-base max-sm:text-sm">{{ $subject->subj_name }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <span class="flex mx-4 items-center max-sm:mx-2">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>
        @endforeach
    @else
        <div
            class="bg-accent flex flex-1 min-h-0 overflow-y-auto justify-center items-center h-auto w-full py-12 max-md:py-8 max-sm:py-6">
            <div class="flex flex-col w-full items-center justify-center mt-3 mb-2 px-4 max-sm:px-2">
                <x-bladewind.icon name="book-open" type="outline"
                    class="!h-24 !w-24 !fill-gray-300 !stroke-gray-500 max-md:!h-16 max-md:!w-16 max-sm:!h-12 max-sm:!w-12" />
                <div class="flex text-center px-4 max-sm:px-2">
                    <p class="font-bold text-[23px] max-md:text-lg max-sm:text-base">No Subjects Available</p>
                </div>
            </div>
        </div>
    @endif
</div>
