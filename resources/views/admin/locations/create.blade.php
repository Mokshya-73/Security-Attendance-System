@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6 px-4">
    <div class="border-4 border-blue-900 rounded-2xl p-6 bg-white shadow">
        <h1 class="text-2xl font-bold text-blue-800 mb-4">+ Add Location</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded">
                <ul class="text-sm list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.locations.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium text-sm text-gray-700">Location Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="flex justify-between items-center mt-4">
                <a href="{{ route('admin.locations.index') }}" class="text-blue-800 hover:text-blue-600">← Back</a>
                <button type="submit" class="bg-blue-800 text-white px-6 py-2 rounded hover:bg-blue-500">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection
