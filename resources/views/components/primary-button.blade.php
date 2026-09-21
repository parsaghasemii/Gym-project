<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-primary disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
