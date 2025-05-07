@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-black border-[3px] rounded-[4px] focus:border-indigo-500 focus:ring-indigo-500 font-poppins shadow-custom-button px-4 py-2']) }}>
