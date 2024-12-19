@extends('layouts.main')

@section('container')
    @include('partials.navbar')

    <div class="mt-5 flex flex-col justify-center items-center mx-auto">
        <h2 class="text-3xl font-bold text-blue-500">Completed Tasks</h2>

        @if ($tasks->isEmpty())
            <p class="text-center text-gray-600 mt-20">No completed tasks</p>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-5 w-full mb-10 justify-center px-5"
            id="task-list">
            @foreach ($tasks as $task)
                <div class="border rounded-lg shadow-xl p-5 bg-gray-50">
                    <h3 class="text-lg font-bold mb-2 capitalize inline-flex w-full justify-between">{{ $task->title }} <p
                            class="
                      text-sm font-medium px-2.5 py-0.5 rounded  text-center mb-4
                      @if ($task->status == 'To Do') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                      @elseif($task->status == 'In Progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                      @elseif($task->status == 'Done') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif
                  "
                            id="task-status-{{ $task->id }}">
                            {{ $task->status }}
                        </p>
                    </h3>
                    <p class="text-xs text-gray-500 mt-2 capitalize mb-5">
                        <span class="font-semibold bg-blue-100 text-blue-800 text-sm me-2 px-2.5 py-0.5 rounded">
                            {{ ucfirst($task->priority) }}
                        </span>
                        | Completed on: {{ $task->updated_at->format('Y-m-d') }}
                    </p>
                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
