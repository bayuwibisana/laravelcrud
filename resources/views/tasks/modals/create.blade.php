@component('components.modal', ['modalId' => 'createTaskModal', 'title' => 'Create New Task', 'action' => route('tasks.store')])

        @include('tasks.partials.form', ['typeAction' => 'add'])

@endcomponent