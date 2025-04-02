@component('components.modal', ['modalId' => 'createProjectModal', 'title' => 'Create New Project', 'action' => route('projects.store')])


    <div class="form-group">
        <label for="project_name">Project Name</label>
        <input type="text" class="form-control @error('project_name') is-invalid @enderror"
            id="project_name" name="project_name" required>
        @error('project_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

@endcomponent