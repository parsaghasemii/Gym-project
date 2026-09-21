@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 focus:border-gym-500 focus:ring-gym-500 rounded-lg shadow-sm']) }}>
