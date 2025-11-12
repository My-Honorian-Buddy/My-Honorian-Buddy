<ul class="space-y-6 flex justify-center items-center flex-col" id="sidebar-item">
    <li class="w-full flex justify-center items-center">
        <a class="group w-full relative inline-block focus:ring-3 focus:outline-hidden" href="{{ route('tutor.profile') }}">
            <span
                class="absolute w-full inset-0 translate-x-0 translate-y-0 bg-primary transition-transform group-hover:translate-x-1.5 group-hover:translate-y-1.5"></span>

            <span
                class="relative text-accent font-poppins w-full text-center inline-block border-2 border-charcoal px-8 py-3 text-sm font-bold tracking-widest uppercase">
                Profile
            </span>
        </a>
    </li>
    <li class="w-full flex justify-center items-center">
        <a class="group w-full relative inline-block focus:ring-3 focus:outline-hidden" href="{{ route('profile.edit-profile') }}">
            <span
                class="absolute w-full inset-0 translate-x-0 translate-y-0 bg-primary transition-transform group-hover:translate-x-1.5 group-hover:translate-y-1.5"></span>

            <span
                class="relative text-accent font-poppins w-full text-center inline-block border-2 border-charcoal px-8 py-3 text-sm font-bold tracking-widest uppercase">
                Edit Your Profile
            </span>
        </a>
    </li>
    <li class="w-full flex justify-center items-center">
        <a class="group w-full relative inline-block focus:ring-3 focus:outline-hidden" href="{{ route('profile.account-settings') }}">
            <span
                class="absolute w-full inset-0 translate-x-0 translate-y-0 bg-primary transition-transform group-hover:translate-x-1.5 group-hover:translate-y-1.5"></span>

            <span
                class="relative text-accent font-poppins w-full text-center inline-block border-2 border-charcoal px-8 py-3 text-sm font-bold tracking-widest uppercase">
                Account Settings
            </span>
        </a>
    </li>
</ul>
