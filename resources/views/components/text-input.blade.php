@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-[#550000] !important  bg-accent3 border-black placeholder-[#110606]
border-[3px] rounded-[4px] shadow-custom-button px-4 py-2']) }}>
