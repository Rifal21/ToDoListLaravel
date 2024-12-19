<div class="flex flex-wrap gap-5 mt-5">
    @foreach ($tasks as $task)
        <div class="w-full md:w-1/3 border rounded-lg shadow-xl p-5 bg-gray-50">
            <h3 class="text-lg font-bold mb-2">{{ $task->title }}</h3>
            <p class="text-sm text-gray-600">{{ $task->description }}</p>
            <p class="text-xs text-gray-500 mt-2">{{ $task->priority }} | Due: {{ $task->due_date }}</p>
            <p class="text-xs text-gray-500 mt-2">Status: {{ $task->status }}</p>
        </div>
    @endforeach
</div>
