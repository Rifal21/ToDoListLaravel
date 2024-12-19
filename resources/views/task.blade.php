@extends('layouts.main')

@section('container')
    @if (session()->has('success'))
        <div id="floating-success"
            class="fixed top-20 right-4 bg-green-600 text-white text-sm px-4 py-2 rounded-lg shadow-lg z-50">
            {{ session('success') }}
        </div>
    @endif
    @include('partials.navbar')

    <div class="mt-5 flex flex-col justify-center items-center mx-auto">
        <h2 class="text-3xl font-bold text-blue-500">Your Tasks</h2>

        <div class="mt-5 flex justify-center">
            <form id="filter-form" class="flex flex-col md:flex-row justify-center items-center gap-3 w-full  px-4">
                <input type="search" id="search-input" name="search" value="{{ old('search', $search) }}"
                    placeholder="Search by title or description"
                    class="p-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 flex-grow w-full md:w-auto" />

            </form>
            <button id="filter-button"
                class="p-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 flex items-center gap-2">
                <i class="fas fa-filter"></i>
                <span class="hidden md:inline">Filter</span>
            </button>
        </div>


        <div id="filter-modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
            <div class="bg-white w-11/12 max-w-md rounded-lg shadow-lg p-5">
                <h3 class="text-lg font-bold mb-4 text-blue-500">Filter Tasks</h3>
                <form id="filter-form" class="flex flex-col gap-4">


                    <select id="status-select" name="status"
                        class="p-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full">
                        <option value="">All Status</option>
                        <option value="To Do" {{ $statusFilter == 'To Do' ? 'selected' : '' }}>To Do</option>
                        <option value="In Progress" {{ $statusFilter == 'In Progress' ? 'selected' : '' }}>In Progress
                        </option>
                    </select>


                    <select id="priority-select" name="priority"
                        class="p-2 border rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 w-full">
                        <option value="">All Priorities</option>
                        <option value="low" {{ $priorityFilter == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $priorityFilter == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $priorityFilter == 'high' ? 'selected' : '' }}>High</option>
                    </select>


                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded mr-2">Apply</button>
                        <button type="button" id="close-modal"
                            class="text-white bg-red-400 hover:bg-red-700 py-2 px-4 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        @if ($tasks->isEmpty())
            <p class="text-center text-gray-600 mt-20">No tasks found</p>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-5 w-full mb-10 justify-center px-5"
            id="task-list">
            @foreach ($tasks as $task)
                <div class="border rounded-lg shadow-xl p-5 bg-gray-50" id="task-{{ $task->id }}">
                    <div class="-mb-[25px] flex justify-end gap-2">

                        <button onclick="editTask({{ $task->id }})" class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-edit"></i>
                        </button>

                        <form action="{{ route('task.destroy', $task->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700"
                                onclick="return confirm('Are you sure you want to delete this task?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>

                    <p class="
                    text-sm font-medium px-2.5 py-0.5 rounded w-1/2 text-center mb-4
                    @if ($task->status == 'To Do') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                    @elseif($task->status == 'In Progress') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                    @elseif($task->status == 'Done') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif
                "
                        id="task-status-{{ $task->id }}">
                        {{ $task->status }}
                    </p>
                    <h3 class="text-lg font-bold mb-2 capitalize" id="task-title-{{ $task->id }}">{{ $task->title }}
                    </h3>
                    <p class="text-xs text-gray-500 mt-2 capitalize mb-3">
                        <span
                            class="
                              font-semibold text-sm px-2.5 py-0.5 rounded dark:text-white
                              @if ($task->priority == 'low') bg-green-100 text-green-800 dark:bg-green-900
                              @elseif($task->priority == 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900
                              @elseif($task->priority == 'high') bg-red-100 text-red-800 dark:bg-red-900 @endif
                          ">
                            {{ ucfirst($task->priority) }}
                        </span>{{ ' ' }}
                        | Due: {{ $task->due_date }}
                    </p>
                    <p class="text-sm text-gray-600" id="task-description-{{ $task->id }}">{{ $task->description }}
                    </p>



                    <div id="edit-form-{{ $task->id }}" class="hidden mt-3">
                        <form action="{{ route('task.update', $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="text" name="title" id="edit-title-{{ $task->id }}"
                                value="{{ $task->title }}" class="w-full p-2 border rounded-md mb-2" required />
                            <textarea name="description" id="edit-description-{{ $task->id }}" class="w-full p-2 border rounded-md mb-2"
                                required>{{ $task->description }}</textarea>
                            <select name="priority" id="edit-priority-{{ $task->id }}"
                                class="w-full p-2 border rounded-md mb-2" required>
                                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            <input type="date" name="due_date" id="edit-due-date-{{ $task->id }}"
                                value="{{ $task->due_date }}" class="w-full p-2 border rounded-md mb-2" required />
                            <select name="status" id="edit-status-{{ $task->id }}"
                                class="w-full p-2 border rounded-md mb-2" required>
                                <option value="To Do" {{ $task->status == 'To Do' ? 'selected' : '' }}>To Do</option>
                                <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="Done" {{ $task->status == 'Done' ? 'selected' : '' }}>Done</option>
                            </select>

                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update</button>
                            <button type="button" onclick="cancelEdit({{ $task->id }})"
                                class="text-red-500 hover:text-red-700 ml-2">Cancel</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const Box = document.getElementById('floating-success');
            if (Box) {
                setTimeout(() => {
                    Box.style.transition = 'opacity 0.5s ease-in-out';
                    Box.style.opacity = '0';
                    setTimeout(() => Box.remove(), 500);
                }, 3000);
            }
        });

        const filterForm = document.getElementById('filter-form');
        const searchInput = document.getElementById('search-input');

        const submitForm = () => {
            filterForm.submit();
        }


        searchInput.addEventListener('input', submitForm);
        statusSelect.addEventListener('change', submitForm);
        prioritySelect.addEventListener('change', submitForm);

        function editTask(taskId) {
            document.getElementById(`task-title-${taskId}`).classList.add('hidden');
            document.getElementById(`task-description-${taskId}`).classList.add('hidden');
            document.getElementById(`task-status-${taskId}`).classList.add('hidden');
            document.getElementById(`edit-form-${taskId}`).classList.remove('hidden');
        }


        function cancelEdit(taskId) {
            document.getElementById(`task-title-${taskId}`).classList.remove('hidden');
            document.getElementById(`task-description-${taskId}`).classList.remove('hidden');
            document.getElementById(`task-status-${taskId}`).classList.remove('hidden');
            document.getElementById(`edit-form-${taskId}`).classList.add('hidden');
        }


        document.addEventListener('DOMContentLoaded', () => {
            const errorBox = document.getElementById('floating-success');
            if (errorBox) {
                setTimeout(() => {
                    errorBox.style.transition = 'opacity 0.5s ease-in-out';
                    errorBox.style.opacity = '0';
                    setTimeout(() => errorBox.remove(), 500);
                }, 3000);
            }
        });
    </script>
    <script>
        const filterButton = document.getElementById('filter-button');
        const filterModal = document.getElementById('filter-modal');
        const closeModal = document.getElementById('close-modal');

        filterButton.addEventListener('click', () => {
            filterModal.classList.remove('hidden');
        });


        closeModal.addEventListener('click', () => {
            filterModal.classList.add('hidden');
        });

        filterModal.addEventListener('click', (e) => {
            if (e.target === filterModal) {
                filterModal.classList.add('hidden');
            }
        });
    </script>
@endsection
