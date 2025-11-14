@php
    $user = Auth::user();
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent rounded-md  border-charcoal border-4">
        <div class="relative rounded-[20px] px-8">
            <!-- Card Content-->

            <div class="flex flex-col mt-8 text-left">
                <span class="font-dela font-bold text-4xl m-5 mb-0 leading-relaxed">
                    @if ($user->role === 'Student')
                        Subject Improvement:
                </span>
                <span class="italic font-semibold text-primary text-1xl mb-8 ml-5">Update your account's profile
                    information and email address.</span>
                @foreach ($user->student->subject_student as $subject)
                    <span class="font-bold text-2xl ml-5">{{ $subject->subj_code }}</span>
                    <span class="font-semibold text-primary text-1xl mb-5 ml-5">{{ $subject->subj_name }}</span>
                @endforeach
            @else
                Subject Expertise:
                </span>
                <span class="italic font-semibold text-primary text-1xl mb-8 ml-5">Update your account's profile
                    information and email address.</span>
                @foreach ($user->tutor->subject_tutor as $subject)
                    <span class="font-bold text-2xl ml-5">{{ $subject->subj_code }}</span>
                    <span class="font-semibold text-primary text-1xl mb-5 ml-5">{{ $subject->subj_name }}</span>
                @endforeach
                @endif

            </div>

            <!-- Buttons  // Change Subject Modal // delete existing chosen subjects and route it to workspace-->
            <div class="flex justify-end mb-8">
                <div class="w-auto mt-6 m-8 flex justify-end">
                    <button 
                        onclick="showModal('changeSubjectModal')"
                        type="submit"
                        class="sm:w-auto bg-accent px-6 sm:px-8 md:px-10 py-2 sm:py-2.5 md:py-1 h-auto sm:h-10 md:h-11 border-2 border-black
                                active:scale-95 transition-all duration-800 ease-in-out flex items-center justify-center rounded-sm font-bold text-sm
                                hover:bg-primary w-auto hover:text-accent tracking-widest uppercase hover:shadow-custom-button">
                        Change Subjects
                    </button>
                </div>
                <x-bladewind.modal name="changeSubjectModal" :show_footer="false" :close_on_outside_click="true" :close_on_escape="true"
                    size="large" cancel_button_label="" ok_button_label="">
                    <form action="{{ route('profile.change-subjects') }}" method="post">
                        @csrf
                        <div class="flex flex-col m-8 mb-2 text-left h-auto">
                            <span class="font-bold text-2xl text-black leading-relaxed">
                                Subject Change Confirmation
                            </span>
                            <span class="font-semibold text-primary text-1xl mb-8 ml-0">
                                Changing your subjects will remove your current selections,
                                and you will need to choose them again.
                            </span>
                            <button type="submit"
                                class="p-3 px-6 border-2 border-black rounded-md text-base font-bold uppercase tracking-wider
                                    transition-all duration-300 ease-in-out hover:scale-105 hover:opacity-90
                                     bg-[#5C0F0F] text-white shadow-lg">
                                Change Subjects
                            </button>
                        </div>
                    </form>
                </x-bladewind.modal>
            </div>
        </div>
    </div>
</div>
