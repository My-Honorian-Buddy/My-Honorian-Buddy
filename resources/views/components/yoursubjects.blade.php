@props(['pickedSubjects', 'user'])
<div
    class="w-full flex flex-col bg-accent rounded-md overflow-hidden border-charcoal border-2 md:max-lg:w-full sm:w-full">
    <div class="flex bg-accent items-center justify-between w-full border-charcoal py-2">
        <div
            class="font-dela flex w-[50%] justify-start text-xl text-charcoal font-black ml-8 max-md:ml-4 max-md:text-base max-sm:text-sm">
            Your Subjects
        </div>


        <p onclick="showModal('changeSubjectModal')" class="w-[50%] text-right mr-8 cursor-pointer hover:underline hover:text-primary">
            Change Subjects
        </p>

        <x-bladewind.modal-explore name="changeSubjectModal" :show_footer="false" :close_on_outside_click="true" :close_on_escape="true" size="large"
            show_action_buttons="false">
            <form action="{{ route('profile.change-subjects') }}" method="post">
                @csrf
                <div class="flex flex-col mb-2 text-left h-auto">
                    <span class="font-bold text-2xl text-black leading-relaxed">
                        Subject Change Confirmation
                    </span>
                    <span class="font-semibold text-primary text-1xl mb-8 ml-0">
                        Changing your subjects will remove your current selections,
                        and you will need to choose them again.
                    </span>
                    <button type="submit"
                        class="p-2 border-2 border-charcoal rounded-sm text-lg
                                    transition-all duration-600 ease-in-out hover:bg-primary hover:text-accent
                                     bg-accent text-charcoal uppercase tracking-widest ">
                        Change
                    </button>
                </div>
            </form>
        </x-bladewind.modal-explore>

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
                            <span
                                class="font-semibold text-xl text-primary italic max-md:text-base max-sm:text-sm">{{ $subject->subj_name }}</span>
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
