@props(['messages' => null, 'field' => null])

@php
    use App\Support\ValidationPresenter;

    $resolvedMessages = $field !== null
        ? ValidationPresenter::messages($errors, $field)
        : $messages;
@endphp

@if ($resolvedMessages)
    <ul {{ $attributes->merge(['class' => 'mt-1.5 space-y-1 text-xs text-red-600']) }}>
        @foreach ((array) $resolvedMessages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
