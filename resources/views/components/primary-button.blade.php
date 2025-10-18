<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full sm:w-auto bg-accent px-6 sm:px-8 md:px-10 py-2 sm:py-2.5 md:py-1 h-auto sm:h-10 md:h-11 rounded-[4px] text-sm sm:text-base border-2 border-black
                                        transition-all duration-800 ease-in-out']) }}>
    {{ $slot }}
</button>

