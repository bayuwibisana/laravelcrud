@component('components.modal', ['modalId' => 'editTaskModal', 'title' => 'Edit Task'])
    
        @include('tasks.partials.form', ['typeAction' => 'edit'])

@endcomponent