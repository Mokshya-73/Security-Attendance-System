@props(['title', 'viewRoute'])

<div class="bg-white shadow-md border border-blue-200 rounded-lg p-5 flex flex-col justify-between">
    <h2 class="text-xl font-semibold text-blue-800 mb-4">{{ $title }}</h2>
    <div class="flex justify-between mt-auto">
        <a href="{{ $viewRoute }}" class="bg-blue-700 text-white px-3 py-1 rounded hover:bg-blue-800 text-sm">View All</a>
    </div>
</div>
