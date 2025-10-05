@props(['pickedSubjects', 'user'])
<div data-aos="fade-up" data-aos-anchor-placement="top-bottom"
    class="w-full mt-10 bg-accent3 rounded-[20px] overflow-hidden shadow-custom-button shadow-black border-black border-2 ">
    <div class="flex bg-primary items-center w-full border-b-2 border-black py-2">

        <div class="flex w-full justify-start text-2xl text-[#ffdd57] text-stroke font-black ml-8">YOUR SUBJECTS</div>
    </div>
    {{-- session #1 --}}

    @if (!empty($pickedSubjects))
        @foreach ($pickedSubjects as $subject)
            <div class="bg-accent3 flex items-center w-full border-b-2 border-black py-2">
                <span class="h-6 w-6 ml-10 bg-primary border-2 border-black rounded-full shrink-0"></span>
                <div class="grid grid-rows-1 mt-7 mb-7">
                    <div class="">
                        <p class="font-bold ml-5 text-[23px]">{{ $subject->subj_code }} - {{ $subject->subj_name }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="bg-accent3 flex items-center w-full border-b-2 border-black py-2">
            <div class="flex flex-col w-full h-full items-center justify-center mt-3 mb-2">
                <x-bladewind.icon name="book-open" type="outline" class="!h-24 !w-24 !fill-gray-300 !stroke-gray-500" />
                <div class="flex text-center">
                    <p class="font-bold ml-5 text-[23px]">No Subjects Available</p>
                </div>
            </div>
        </div>
    @endif
</div>
