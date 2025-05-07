<section class="m-8">
    <!-- container SINIRA MO NO-->
    <div class="bg-accent2 rounded-[20px] pt-2 pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
        <div class="flex bg-white -mt-2 items-center w-full border-b-2 border-black py-2 rounded-t-[20px]">
            <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
            </div>
            <div class="flex w-full justify-end text-2xl text-accent text-stroke font-black mr-8">UPCOMING TASK</div>
        </div> 
        <!-- upcoming tasks, checkboxes -->
        <div class="bg-accent2 w-full p-2 space-y-3 rounded-[20px]">
            <form id="addTaskForm" class="flex flex-col px-6 space-y-4"method="POST" action="{{ route('tasks.store') }}">
                @csrf
                <input type="text" name="title" placeholder="To Do Task" class="py-3 px-6 bg-gray-100 rounded-md">
                    
                <button type="submit" class="flex items-center justify-center w-28 h-12 border-2 border-primary py-4 px-8 text-primary rounded-md 
                hover:bg-primary hover:text-accent2 transition ease-in-out">Add</button>
            </form>

            @php
                $todolists = Auth::user()->to_do_lists;
            @endphp
            <div id="taskList" class="space-y-3 pt-10 px-6">
                @foreach ($todolists as $task)
                    <div id="task-{{ $task->id }}" class="bg-white flex items-center justify-between h-12 border-2 border-black rounded-md">
                        <input type="checkbox" 
                            onchange="toggleTaskStatus({{ $task->id }}, this.checked)"
                            class="peer ml-4" 
                            {{ $task->is_completed ? 'checked' : '' }}>
                        <label class="{{ $task->is_completed ? 'line-through text-red-600' : '' }}">
                            {{ $task->title }}
                        </label>
                        <button onclick="deleteTask({{ $task->id }})" class="text-primary mr-4 hover:underline">Delete</button>
                    </div>
                @endforeach
            </div>
        </div>

        <hr class="border-1 border-black">

        <div class="mt-2">
            <div class="py-4 flex items-center px-3">
            
            </div>
        </div>
    </div>
</section>

{{-- script for upcoming task --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
    $('#addTaskForm').on('submit', function(event) {
        event.preventDefault(); 

        $.ajax({
            url: '{{ route('tasks.store') }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log("Task added successfully!");
                
                $('#taskList').append(`
                    <div id="task-${response.task.id}" class="bg-white flex items-center justify-between h-12 border-2 border-black rounded-md">
                        <input type="checkbox" onchange="toggleTaskStatus(${response.task.id}, this.checked)"
                                class="peer ml-4">
                        <label>${response.task.title}</label>
                        <button onclick="deleteTask(${response.task.id})" class="text-primary mr-4 hover:underline">Delete</button>
                    </div>
                `);


                $('#addTaskForm')[0].reset();
            },
            error: function(xhr) {
                console.error("Error adding task:", xhr.responseText);
            }
        });
    });

    
    function toggleTaskStatus(taskId, isChecked) {
        $.ajax({
            url: `/workspace/tasks/${taskId}`,
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                is_completed: isChecked
            },
            success: function(response) {
                console.log("Task status updated successfully!");
                const taskLabel = $(`#task-${taskId} label`);
                if (isChecked) {
                    taskLabel.addClass('line-through text-red-600');
                } else {
                    taskLabel.removeClass('line-through text-red-600');
                }
            },
            error: function(xhr) {
                console.error("Error updating task status:", xhr.responseText);
            }
        });
    }


    function deleteTask(taskId) {
        if (!confirm("Are you sure you want to delete this task?")) return;

        $.ajax({
            url: `/workspace/tasks/${taskId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log("Task deleted successfully!");
                $(`#task-${taskId}`).remove();
            },
            error: function(xhr) {
                console.error("Error deleting task:", xhr.responseText);
            }
        });
    }
</script>