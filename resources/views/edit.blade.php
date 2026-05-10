@extends('app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Edit Todo</h3>
    </div>

    <div class="card-body">

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">

                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach

            </ul>
        </div>
        @endif

        <form
            action="{{ route('todos.update', $todo->id) }}"
            method="POST">
            @csrf
            @method('PUT')

            @include('form')
        </form>

    </div>
</div>

@endsection