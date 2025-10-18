<h1 {{
    $attributes -> merge([
        'class' => 'font-poppins font-bold text-center text-2xl sm:text-3xl md:text-4xl lg:text-[54px] text-secondary'
    ])
}}>
    {{ $slot }}
</h1>