@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'text-[#550000] !important  bg-[#FFF8E1] border-black placeholder-[#110606]
border-[3px] rounded-[4px] focus:border-indigo-500 focus:ring-indigo-500 font-poppins shadow-custom-button px-4 py-2']) }}>
