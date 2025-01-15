<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-auto bg-accent text-primary px-10 py-1 h-11 rounded-[4px] text-l border-2 border-black shadow-custom-button
                                        hover:bg-secondary hover:text-[#8B3A3A]']) }}>
    {{ $slot }}
</button>

