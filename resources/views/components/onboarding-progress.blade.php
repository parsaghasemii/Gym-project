@props(['step'])

<div class="flex items-center justify-center gap-2 mb-8">
    @foreach ([1, 2, 3, 4] as $i)
        <div @class([
            'h-2 rounded-full transition-all',
            $i <= $step ? 'bg-gym-600 w-8' : 'bg-slate-200 w-2',
        ])></div>
    @endforeach
</div>
<p class="text-center text-sm text-slate-500 mb-6">مرحله {{ $step }} از ۴</p>
