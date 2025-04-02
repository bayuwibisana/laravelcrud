

@if(isset($typeAction) && $typeAction == 'edit')
    @method('PUT')
@endif

<div class="form-group">
    <label for="name">Task Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" 
           id="task_name_{{ $typeAction }}" name="task_name" value="{{ old('task_name', $taskEdit->task_name ?? '') }}" required>
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="project_id">Project Name</label>
        @include('components.projectsoptions', ['projects' => $projects, 'selectedProject' => $taskEdit->project_id ?? null])
    @error('project_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>