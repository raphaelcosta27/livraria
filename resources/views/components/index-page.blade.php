@props([
    'title',
    'createRoute',
    'createLabel' => 'Novo',
])

<div class="flex justify-center px-4 py-8">
    <div class="w-full">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">{{ $title }}</h1>
            <a href="{{ route($createRoute) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ $createLabel }}
            </a>
        </div>
        <x-flash-message type="success" :message="session('success')" />
        <x-flash-message type="error" :message="session('error')" />

        {{ $slot }}
    </div>
</div>
