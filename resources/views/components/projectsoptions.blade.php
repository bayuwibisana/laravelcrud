<select name="project_id" class="form-control @error('project_name') is-invalid @enderror" id="project_id_{{ $typeAction }}" required>
  <option value="" disabled selected>Select a project</option>
  @foreach($projects as $project)
  <option value="{{ $project->id }}" {{ $project->id == $selectedProject ? 'selected' : '' }}> {{ $project->project_name }}</option>
  @endforeach
</select>