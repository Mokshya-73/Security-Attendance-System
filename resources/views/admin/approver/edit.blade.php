@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4">
     <div class="border-4 border-blue-900 rounded-2xl p-6 bg-blue shadow-[0_4px_12px_rgba(0,0,0,0.7)]">
    <h1 class="text-2xl font-bold text-blue-800 mb-4">Edit Approver</h1>

    <form action="{{ route('admin.approver.update', $dgm->id) }}" method="POST" class="bg-white p-6 shadow rounded-lg border border-blue-200">
        @csrf

        <div class="mb-4">
            <label for="name" class="block font-medium text-sm text-gray-700">Name</label>
            <input type="text" name="name" value="{{ $dgm->name }}" class="w-full mt-1 border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label for="employee_id" class="block font-medium text-sm text-gray-700">Employee ID</label>
            <input type="text" name="employee_id" value="{{ $dgm->employee_id }}" class="w-full mt-1 border rounded px-3 py-2" required>
        </div>

     <div class="flex justify-between items-center mt-16">
  <!-- Back button on left -->
 <a href="{{ route('admin.dashboard') }}" 
               class="group relative inline-block text-blue-800 font-semibold px-4 py-2 hover:text-blue-600 focus:outline-none">
   ← Back
                <span class="absolute left-0 -bottom-0.5 w-full h-0.5 bg-blue-600 scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
</a>
            <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 transition-colors">
                Update
            </button>
        </div>    </form>
</div>
@endsection
