<h1 {{
    $attributes -> merge([
        'class' => 'font-poppins font-bold drop-shadow-custom-drop-shadow text-[64px] text-secondary'
    ])
}}>
    {{ $slot }}
</h1>