@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-black !important bg-accent border-charcoal placeholder-[#110606]
border-2 rounded-sm px-4 py-2 placeholder-gray-500']) }}>
