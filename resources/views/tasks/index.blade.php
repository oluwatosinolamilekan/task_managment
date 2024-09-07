<!-- resources/views/tasks/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold text-center mb-4">Task Management</h1>

        <!-- Display any success messages -->
        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif
        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
            </div>
        @endif

        <!-- Task Table -->
        <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-800 text-white text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Task Name</th>
                        <th class="py-3 px-6 text-left">Description</th>
                        <th class="py-3 px-6 text-center">Status</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse ($tasks as $key => $task)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">{{ ++$key }}</td>
                            <td class="py-3 px-6 text-left">{{ $task->name }}</td>
                            <td class="py-3 px-6 text-left">{{ $task->description }}</td>
                            <td class="py-3 px-6 text-center">
                                @if ($task->is_completed)
                                    <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Completed</span>
                                @else
                                    <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">Pending</span>
                                @endif
                            </td>
                            <td class="py-3 px-6 text-center">
                                @if (!$task->is_completed)
                                    <form action="{{ url('/tasks/' . $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button class="bg-blue-500 text-white py-1 px-4 rounded hover:bg-blue-600 text-xs">
                                            Mark as Completed
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">No tasks found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $tasks->links() }}
        </div>

       <!-- Modal Trigger and Content -->
        <div x-data="{ open: false }">
            <!-- Trigger for the Modal -->
            <div class="mt-6 text-center">
                <button @click="open = true" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Create New Task</button>
            </div>

            <!-- Modal -->
            <div x-show="open"  class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" @click.away="open = false">
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <h2 class="text-2xl font-bold mb-4">Create New Task</h2>

                    <!-- Task Creation Form -->
                    <form action="{{ url('/tasks') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Task Name</label>
                            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Task Description</label>
                            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                        </div>

                        <div class="flex justify-between items-center">
                            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">Create Task</button>
                            <button type="button" @click="open = false" class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
