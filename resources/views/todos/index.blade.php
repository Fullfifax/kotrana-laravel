@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row mb-3">
            <div class="col-md-8">
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
                <div class="row">
                    <div class="col-sm">
                        {{ $data->name }}
                        @if($data->done)
                            <span class="badge bg-success text-light">done</span>
                        @endif
                    </div>
                    <div class="col-sm d-flex justify-content-end">
                        {{-- Button affected to user --}}
                        <div class="dropdown show mx-3">
                            <a class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Affect to
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                @foreach ($users as $user)
                                    <a class="dropdown-item" href="/todos/{{ $data->id }}/affectedTo/{{ $user->id }}">{{ $user->name }}</a>
                                @endforeach
                            </div>
                          </div>
                        {{-- Button Done/Undone --}}
                        @if($data->done == 0)
                        <form action="{{ route('todos.makedone', $data->id) }}" method="post">
                            @csrf
                            <!--  Data existed update -->
                            @method('PUT')
                            <button type="submit" class="btn btn-warning">Undone</button>
                        </form>
                        @else
                        <form action="{{ route('todos.makeundone', $data->id) }}" method="post">
                            @csrf
                            <!--  Data existed update -->
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Done</button>
                        </form>
                        @endif
                        {{-- Button edit --}}
                        <a class="btn btn-secondary text-light mx-3" href="{{ route('todos.edit', $data->id) }}" type="button">Edit</a>
                        {{-- Button delete --}}
                        <form action="{{ route('todos.destroy', $data->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger text-light">Delete</a>
                        </form>
                        
                    </div>
                </div>
            </div>
        @endforeach

        {{ $datas->links("pagination::bootstrap-4") }}

    </div>

@endsection






