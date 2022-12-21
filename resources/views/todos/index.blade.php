@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row mb-3">
            <div class="col-md-2">
                <a href="{{ route('todos.create') }}" class="btn btn-secondary">Add new task</a>
            </div>
            <div class="col-md-2">
                @if(Route::currentRouteName() == 'todos.index')
                    <a href="{{ route('todos.undone') }}" class="text-light btn btn-warning">Todo undone</a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('todos.done') }}" class="btn btn-success">Todo done</a>
            @elseif(Route::currentRouteName() == 'todos.done')
            <a href="{{ route('todos.index') }}" class="text-light btn btn-dark">All todos</a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('todos.undone') }}" class="btn btn-warning">Todo undone</a>
                @elseif(Route::currentRouteName() == 'todos.undone')
                <a href="{{ route('todos.index') }}" class="text-light btn btn-dark">All todos</a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('todos.done') }}" class="btn btn-success">Todo done</a>
                @endif
            </div>
        </div>

        @foreach ($datas as $data)
            <div class="alert alert-{{ $data->done ? 'success' : 'warning'}}" role="alert">    
                {{ $data->name }}
                @if($data->done)
                    <span class="badge bg-success text-light">done</span>
                @endif
            </div>
        @endforeach

        {{ $datas->links("pagination::bootstrap-4") }}

    </div>

@endsection






