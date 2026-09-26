<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8fafc; 
            color: #0f172a;
        }
    </style>
</head>
<body class="min-h-screen p-6 md:p-12 flex items-center justify-center antialiased">

    <div class="max-w-xl w-full">
        
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-bold text-slate-900">Edit Task</h1>
                <p class="text-xs text-slate-500">Modify details for this specific task record.</p>
            </div>
            <a href="{{ route('tasks.index') }}" class="text-xs text-slate-500 hover:text-indigo-600 transition-colors flex items-center space-x-1.5 font-medium">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Back to Tasks</span>
            </a>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl p-6 md:p-8 shadow-sm">
            <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Task Title</label>
                    <input type="text" name="task_name" value="{{ $task->task_name }}" required 
                           class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Description / Notes</label>
                    <textarea name="description" rows="3" 
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none">{{ $task->description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Status</label>
                        <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Completed" {{ $task->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" value="{{ $task->due_date }}" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('tasks.index') }}" class="px-4 py-2.5 text-xs font-medium text-slate-600 hover:text-slate-900 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs rounded-lg transition-colors shadow-sm">
                        Update Task
                    </button>
                </div>
            </form>
        </div>

    </div>
</body>
</html>