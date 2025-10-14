@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-gray-400/75 !important  bg-accent3 border-black placeholder-[#110606]
border-[1px] rounded-[4px] px-4 py-2 ']) }}>
