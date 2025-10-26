@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-black !important  bg-accent border-gray-300 placeholder-[#110606]
border rounded-[4px] px-4 py-2 placeholder-gray-500']) }}>
