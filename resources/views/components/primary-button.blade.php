<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-auto bg-accent px-10 py-1 h-11 rounded-[4px] text-l border-2 border-black shadow-custom-button
                                        transition-all duration-600 ease-in-out hover:scale-110']) }}>
    {{ $slot }}
</button>

