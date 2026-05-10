@extends('app')

@section('content')

<div class="card">
    <div class="card-header">
        <h3>Create Todo</h3>
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

        <form action="{{ route('todos.store') }}" method="POST">
            @csrf

            @include('form')
        </form>

    </div>
</div>

@endsection