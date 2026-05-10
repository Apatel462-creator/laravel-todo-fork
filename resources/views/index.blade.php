@extends('app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h2>Todo List</h2>

    <a href="{{ route('todos.create') }}" class="btn btn-primary">
        Create Todo
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th width="250">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($todos as $todo)

                <tr>
                    <td>{{ $todo->id }}</td>

                    <td>
                        @if($todo->is_completed)
                        <del>{{ $todo->title }}</del>
                        @else
                        {{ $todo->title }}
                        @endif
                    </td>

                    <td>
                        <span class="badge bg-info">
                            {{ $todo->status }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-warning text-dark">
                            {{ $todo->priority }}
                        </span>
                    </td>

                    <td>
                        {{ $todo->due_date ?? 'N/A' }}
                    </td>

                    <td class="d-flex gap-2">

                        <a
                            href="{{ route('todos.show', $todo->id) }}"
                            class="btn btn-sm btn-info">
                            View
                        </a>

                        <a
                            href="{{ route('todos.edit', $todo->id) }}"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form
                            action="{{ route('todos.complete', $todo->id) }}"
                            method="POST">
                            @csrf
                            @method('PATCH')

                            <button class="btn btn-sm btn-success">
                                Complete
                            </button>
                        </form>

                        <form
                            action="{{ route('todos.destroy', $todo->id) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete todo?')">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center">
                        No Todos Found
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        {{ $todos->links() }}

    </div>
</div>

@endsection