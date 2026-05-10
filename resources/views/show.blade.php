@extends('app')

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">
        <h3>Todo Details</h3>

        <a
            href="{{ route('todos.index') }}"
            class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="200">Title</th>
                <td>{{ $todo->title }}</td>
            </tr>

            <tr>
                <th>Description</th>
                <td>{{ $todo->description }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>{{ $todo->status }}</td>
            </tr>

            <tr>
                <th>Priority</th>
                <td>{{ $todo->priority }}</td>
            </tr>

            <tr>
                <th>Due Date</th>
                <td>{{ $todo->due_date }}</td>
            </tr>

            <tr>
                <th>Completed</th>
                <td>
                    {{ $todo->is_completed ? 'Yes' : 'No' }}
                </td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>{{ $todo->created_at }}</td>
            </tr>

        </table>

    </div>

</div>

@endsection