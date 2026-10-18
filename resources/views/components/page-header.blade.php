@props(['title', 'subtitle' => null])

<h1 class="text-3xl font-bold mb-2">{{ $title }}</h1>

@if ($subtitle)
    <p class="mb-6 text-lg text-gray-600">{{ $subtitle }}</p>
@else
    <div class="mb-6"></div>
@endif
