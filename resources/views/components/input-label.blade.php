@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold font-poppins']) }}>
    {{ $value ?? $slot }}
</label>
