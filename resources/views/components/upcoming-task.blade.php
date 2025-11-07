<section class="">
    <!-- container SINIRA MO NO-->
    <section>
        <div class="bg-accent rounded-md overflow-hidden pt-2 pb-2 mb-4 border-black border-2">
            <div class="flex items-center bg-accent w-full border-charcoal py-2">
                <div
                    class="font-dela flex w-full justify-start text-xl text-darkgray font-bold ml-8 max-md:ml-4 max-md:text-lg">
                    TO-DO List
                </div>
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>
            <div class="font-poppins w-full p-2 space-y-3 rounded-[20px]">
                <form id="addTaskForm" class="flex flex-col px-6 space-y-4 max-md:px-3" method="POST"
                    action="{{ route('tasks.store') }}">
                    @csrf
                    <input type="text" name="title" placeholder="To Do Task"
                        class="text-primary py-3 px-6 bg-accent rounded-sm border border-black
                                        text-lg outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 max-md:py-2 max-md:px-4 max-md:text-base">
                    <div class="w-full flex justify-end">
                        <button type="submit"
                            class="flex bg-primary items-center justify-center w-28 h-12 border-2
                                            border-charcoal py-4 px-8 text-accent rounded-sm font-bold 
                                            hover:bg-primary/70 active:scale-95 transition ease-in-out max-md:w-24 max-md:h-10 max-md:py-3 max-md:px-6 max-md:text-sm">Add</button>
                    </div>
                </form>

                @php
                    $todolists = Auth::user()->to_do_lists;
                @endphp
                <div id="taskList" class="space-y-3 pt-10 px-6 max-md:px-3 max-md:pt-6">
                    @foreach ($todolists as $task)
                        <div id="task-{{ $task->id }}"
                            class="bg-accent flex items-center !justify-between h-12 border
                                            text-charcoal font-semibold border-charcoal rounded-sm max-md:min-h-[48px] max-md:h-auto max-md:px-2 max-md:py-2">
                            <input type="checkbox" onchange="toggleTaskStatus({{ $task->id }}, this.checked)"
                                class="peer ml-4 " {{ $task->is_completed ? 'checked' : '' }}>
                            <label
                                class="{{ $task->is_completed ? 'line-through text-red-600' : '' }} flex-1 mx-3 break-words max-md:mx-2 max-md:text-sm">
                                {{ $task->title }}
                            </label>
                            <button onclick="deleteTask({{ $task->id }})"
                                class="text-primary mr-4 hover:underline flex-shrink-0 max-md:mr-2 max-md:text-sm">Delete</button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
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
                    <div id="task-${response.task.id}" class="bg-accent flex items-center justify-between text-charcoal h-12 border border-charcoal rounded-sm">
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
