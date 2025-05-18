@props(['type' => 'success', 'message' => ''])

@php
    $colors = [
        'success' => 'bg-green-200 text-green-800',
        'error' => 'bg-red-200 text-red-800',
        'warning' => 'bg-yellow-200 text-yellow-800',
        'info' => 'bg-blue-200 text-blue-800',
    ];
@endphp

@if ($message)
    <div class="mb-4 p-3 rounded {{ $colors[$type] ?? $colors['info'] }}">
        {{ $message }}
    </div>
@endif
