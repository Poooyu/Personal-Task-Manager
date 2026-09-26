<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8fafc; 
            color: #0f172a;
        }
    </style>
</head>
<body class="min-h-screen p-6 md:p-12 antialiased">

    <div class="max-w-5xl mx-auto">
        
        <!-- Header -->
        <header class="mb-8 pb-6 border-b border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Task Workspace</h1>
                <p class="text-sm text-slate-500 mt-1">Manage, track, and organize daily objectives.</p>
            </div>

            <!-- Stats Bar -->
            <div class="flex items-center space-x-3 text-xs font-medium">
                <div class="bg-white border border-slate-200 px-4 py-2 rounded-lg shadow-sm flex items-center space-x-2">
                    <span class="text-slate-500">Total:</span>
                    <span class="text-slate-900 font-semibold">{{ $tasks->count() }}</span>
                </div>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-2 rounded-lg flex items-center space-x-2">
                    <span>Completed:</span>
                    <span class="font-semibold">{{ $tasks->where('status', 'Completed')->count() }}</span>
                </div>
                <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-2 rounded-lg flex items-center space-x-2">
                    <span>Pending:</span>
                    <span class="font-semibold">{{ $tasks->where('status', 'Pending')->count() }}</span>
                </div>
            </div>
        </header>

        <!-- Flash Alert -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-sm text-emerald-800 flex items-center justify-between shadow-sm">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 transition-colors">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- Create Task Card -->
        <section class="bg-white border border-slate-200 rounded-xl p-6 mb-8 shadow-sm">
            <h2 class="text-sm font-semibold text-slate-900 mb-4 flex items-center space-x-2">
                <i class="fa-solid fa-plus text-indigo-600 text-xs"></i>
                <span>Add New Task</span>
            </h2>

            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Task Title</label>
                        <input type="text" name="task_name" required 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" 
                               placeholder="e.g., Complete System Architecture Document">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Due Date</label>
                        <input type="date" name="due_date" 
                               class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-700 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1">Description / Notes</label>
                    <textarea name="description" rows="2" 
                              class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none" 
                              placeholder="Add contextual details or specific instructions..."></textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs rounded-lg transition-colors shadow-sm flex items-center space-x-2">
                        <i class="fa-solid fa-plus text-[10px]"></i>
                        <span>Save Task</span>
                    </button>
                </div>
            </form>
        </section>

        <!-- Task List -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-slate-500">Task Directory</h2>
                <span class="text-xs text-slate-400">{{ $tasks->count() }} Items Listed</span>
            </div>

            <div class="space-y-3">
                @forelse($tasks as $task)
                    <div class="bg-white border border-slate-200 hover:border-slate-300 rounded-xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 shadow-sm transition-all">
                        
                        <div class="space-y-1.5 flex-1 pr-4">
                            <div class="flex items-center space-x-3">
                                @if($task->status === 'Completed')
                                    <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[11px] font-medium rounded-md">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 text-[11px] font-medium rounded-md">
                                        Pending
                                    </span>
                                @endif

                                <h3 class="text-sm font-semibold {{ $task->status === 'Completed' ? 'line-through text-slate-400' : 'text-slate-800' }}">
                                    {{ $task->task_name }}
                                </h3>
                            </div>

                            @if($task->description)
                                <p class="text-xs text-slate-500 leading-relaxed pl-1">
                                    {{ $task->description }}
                                </p>
                            @endif
                        </div>

                        <!-- Date & Actions -->
                        <div class="flex items-center justify-between md:justify-end space-x-6 border-t md:border-t-0 border-slate-100 pt-3 md:pt-0">
                            
                            <span class="text-xs text-slate-500 flex items-center space-x-1.5">
                                <i class="fa-regular fa-calendar text-slate-400"></i>
                                <span>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No due date' }}</span>
                            </span>

                            <div class="flex items-center space-x-1">
                                <form action="{{ route('tasks.toggleStatus', $task) }}" method="POST" 
                                      onsubmit="{{ $task->status === 'Pending' ? 'triggerConfetti(event, this)' : '' }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-emerald-50 hover:border-emerald-300 text-slate-500 hover:text-emerald-600 flex items-center justify-center transition-all" title="Toggle Status">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </button>
                                </form>

                                <a href="{{ route('tasks.edit', $task) }}" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-slate-100 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors" title="Edit Task">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>

                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg border border-slate-200 hover:bg-rose-50 hover:border-rose-300 text-slate-400 hover:text-rose-600 flex items-center justify-center transition-colors" title="Delete Task">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="text-center py-12 bg-white border border-slate-200 rounded-xl shadow-sm">
                        <i class="fa-regular fa-folder-open text-2xl text-slate-300 mb-2"></i>
                        <p class="text-xs font-medium text-slate-500">No tasks currently recorded.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </div>

    <script>
        function triggerConfetti(e, form) {
            e.preventDefault(); 
            confetti({
                particleCount: 50,
                spread: 60,
                origin: { y: 0.7 },
                colors: ['#4f46e5', '#10b981', '#3b82f6', '#6366f1']
            });
            setTimeout(() => { form.submit(); }, 300); 
        }
    </script>
</body>
</html>