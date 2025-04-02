@extends('layouts.app')

@section('content')
<div class="container">

    <button type="button" class="btn btn-primary mt-4 mb-3" data-bs-toggle="modal" data-bs-target="#createProjectModal">
        Create Project
    </button>

    <button type="button" class="btn btn-primary ml-4 mt-4 mb-3" data-bs-toggle="modal" data-bs-target="#createTaskModal">
        Create Task
    </button>


    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form method="GET" action="{{ route('tasks.filter') }}">
        <select name="project_id" class="form-control" id="project_id_filter" onchange="this.form.submit()">
            <option value="" {{ !isset($selectedProject) ? 'selected' : '' }}>Select a project</option>
            @foreach($projects as $project)
            <option value="{{ $project->id }}" {{ isset($selectedProject) && $project->id == $selectedProject ? 'selected' : '' }}>
                {{ $project->project_name }}
            </option>
            @endforeach
        </select>
    </form>

    <table class="table table-bordered mt-4" id="sortable-table">
        <thead>
            <tr>
                <th class="col-1 text-center text-uppercase font-weight-bold">
                    +
                </th>
                <th class="text-center text-uppercase font-weight-bold">
                    Task Name
                </th>
                <th class="d-none d-md-table-cell text-center text-uppercase font-weight-bold">
                    Position
                </th>
                <th class="col-1 text-center text-uppercase font-weight-bold">
                    Action
                </th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach($tasks as $task)
            <tr data-id="{{ $task->id }}" class="cursor-move">
                <td class="text-center text-uppercase">
                    ⠿
                </td>
                <td class="text-center text-uppercase">
                    {{ $task->task_name }}
                </td>
                <td class="text-center text-uppercase">
                    {{ $task->priority }}
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editTaskModal"
                        data-task-id="{{ $task->id }}"
                        data-task-name="{{ $task->task_name }}"
                        data-project-id="{{ $task->project_id }}"
                        onclick="showEditModal(this)">
                        Edit
                    </button>

                    <!-- Delete Form -->
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Include Modals -->
@include('projects.modals.create')

@include('tasks.modals.create')
@include('tasks.modals.edit')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('sortable-table');

        if (!table) {
            console.error('Sortable table not found!');
            return;
        }

        const tbody = table.querySelector('tbody');
        if (!tbody) {
            console.error('Table body not found!');
            return;
        }

        new Sortable(tbody, {
            animation: 150,
            handle: '.cursor-move',
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                updateTaskPositions();
            }
        });

        function updateTaskPositions() {
            const rows = document.querySelectorAll('#sortable-table tbody tr');
            if (rows.length === 0) return;

            const taskIds = Array.from(rows).map(row => row.getAttribute('data-id'));

            fetch('{{ route("tasks.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        taskIds: taskIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        rows.forEach((row, index) => {
                            const positionCell = row.querySelector('td:nth-child(3)');
                            if (positionCell) {
                                positionCell.textContent = index + 1;
                            }
                        });
                    }
                })
                .catch(console.error);
        }
    });

    function showEditModal(button) {

        const taskId = $(button).attr('data-task-id');
        const taskName = $(button).attr('data-task-name');
        const projectId = $(button).attr('data-project-id');

        $('#task_name_edit').val(taskName);
        $('#project_id_edit').val(projectId);
        $('#editTaskModalForm').attr('action', `/tasks/${taskId}`);


    }
</script>
@endsection