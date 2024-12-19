@extends('layouts.main')

@section('container')
    @include('partials.navbar')

    <main class="min-h-screen flex flex-col justify-start items-center pt-10 ">
        <h1 class="text-4xl font-bold text-blue-500 text-center mb-3 uppercase">ToDo List</h1>


        <div class="flex flex-col w-full">
            <form class="max-w-4xl flex flex-col gap-3 w-full mx-auto rounded-lg p-3" method="POST"
                action="{{ url('/home') }}">
                @csrf
                <div class="md:flex block  gap-3">
                    <div class="mb-2 w-full">
                        <label for="title"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                        <input type="text" id="title" name="title"
                            class="shadow-sm bg-gray-50 border 
                                      @error('title') border-red-500 @else border-gray-300 @enderror
                                      text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                      dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                      dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="Title of your task" required />
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 w-full">
                        <label for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <input id="description" name="description"
                            class="shadow-sm bg-gray-50 border
                                      @error('description') border-red-500 @else border-gray-300 @enderror
                                      text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                      dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                      dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            placeholder="Description of your task" required />
                        @error('description')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="md:flex block gap-3">
                    <div class="mb-2 w-full">
                        <label for="due_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Due
                            Date</label>
                        <input type="date" id="due_date" name="due_date"
                            class="shadow-sm bg-gray-50 border
                                      @error('due_date') border-red-500 @else border-gray-300 @enderror
                                      text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                      dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                      dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                            required />
                        @error('due_date')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-2 w-full">
                        <label for="priority"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Priority</label>
                        <select id="priority" name="priority"
                            class="shadow-sm bg-gray-50 border
                                      @error('priority') border-red-500 @else border-gray-300 @enderror
                                      text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                                      dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                                      dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                        </select>
                        @error('priority')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Add
                    Task</button>
            </form>
        </div>




    </main>
@endsection
