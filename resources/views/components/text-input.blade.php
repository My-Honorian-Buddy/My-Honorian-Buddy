@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-black !important  bg-accent3 border-gray-300 placeholder-[#110606]
border-2 rounded-[4px] px-4 py-2 ']) }}>
