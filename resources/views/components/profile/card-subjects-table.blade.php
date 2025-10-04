@php
    $user = Auth::user();
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent3 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">
            <!-- Card Content-->
                
                    <div class="flex flex-col mt-8 text-left">
                        <span class="font-bold text-4xl m-5 mb-0 leading-relaxed">
                            @if ($user -> role === 'Student')
                                Subject Improvement:
                            </span>
                            <span class="font-semibold text-red-900 text-1xl mb-8 ml-5">Update your account's profile information and email address.</span>
                                @foreach ($user->student->subject_student as $subject)
                                    <span class="font-semibold text-2xl ml-5">{{$subject->subj_code}}</span>
                                    <span class="font-semibold text-red-900 text-1xl mb-5 ml-5">{{$subject->subj_name}}</span>
                                @endforeach
                            @else
                                Subject Expertise:
                            </span>
                            <span class="font-semibold text-red-900 text-1xl mb-8 ml-5">Update your account's profile information and email address.</span>
                                @foreach ($user->tutor->subject_tutor as $subject)
                                    <span class="font-semibold text-2xl ml-5">{{$subject->subj_code}}</span>
                                    <span class="font-semibold text-red-900 text-1xl mb-5 ml-5">{{$subject->subj_name}}</span>
                                @endforeach
                            @endif

                    </div>

                            <!-- Buttons  // Change Subject Modal // delete existing chosen subjects and route it to workspace-->
                    <div class="flex justify-end m-8">
                        <x-primary-button onclick="showModal('changeSubjectModal')" type="submit" class=" bg-accent2 text-black ">Change</x-primary-button>
                        <x-bladewind.modal
                            name="changeSubjectModal"
                            :show_footer="false"
                            :close_on_outside_click="true"
                            :close_on_escape="true"
                            size="large"
                            cancel_button_label=""
                            ok_button_label=""
                        >
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
                                    <button type="submit" class="p-2 shadow-custom-button border-2 border-black rounded-[4px] text-lg
                                    transition-all duration-600 ease-in-out hover:scale-105 hover:bg-primary hover:text-accent2
                                     bg-accent2 text-black ">
                                        Change
                                    </button>
                                </div>
                            </form>
                        </x-bladewind.modal>
                    </div>
        </div>
    </div>
</div>