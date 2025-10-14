<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-auto bg-accent px-10 py-1 h-11 rounded-[4px] text-l border-2 border-black
                                        transition-all duration-800 ease-in-out ']) }}>
    {{ $slot }}
</button>

