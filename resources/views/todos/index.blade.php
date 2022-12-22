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
            <a href="{{ route('todos.index') }}" class="text-light btn btn-secondary">All todos</a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('todos.undone') }}" class="btn btn-warning">Todo undone</a>
                @elseif(Route::currentRouteName() == 'todos.undone')
                <a href="{{ route('todos.index') }}" class="text-light btn btn-secondary">All todos</a>
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
                        <details>
                            <summary>
                                <span class="my-0 bg-secondary text-light p-1">#{{ $data->id }}</span>
                                {{ $data->name }}

                                <small>
                                    (created {{ $data->created_at->from() }} by 
                                    {{ Auth::user()->id == $data->user->id ? 'myself' : $data->user->name }})
                                    
                                    @if ($data->todoAffectedTo && $data->todoAffectedTo->id == Auth::user()->id)
                                        Affected by myself
                                    @elseif ($data->todoAffectedTo)
                                        {{ $data->todoAffectedTo ? ', affected to ' . $data->todoAffectedTo->name : '' }}
                                    @endif
                                    {{-- display affected by someone or by user himself --}}
                                    @if ($data->todoAffectedTo && $data->todoAffectedBy && $data->todoAffectedBy->id == Auth::user()->id)
                                        by myself
                                    @elseif ($data->todoAffectedTo && $data->todoAffectedBy && $data->todoAffectedBy->id != Auth::user()->id)
                                        by {{ $data->todoAffectedBy->name }}
                                    @endif
                                </small>

                                @if($data->done)
                                    <span class="badge bg-success text-light">done</span>
                                    <small>
                                        <p>
                                            Finished
                                            {{ $data->updated_at->from() }} - Finished on 
                                            {{ $data->updated_at->diffForHumans($data->created_at, 1) }}
                                        </p>
                                    </small>
                                @endif
                            </summary>
                            <p>{{ $data->description }}</p>
                        </details>
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
                            <button type="submit" class="btn btn-success">Done</button>
                        </form>
                        @else
                        <form action="{{ route('todos.makeundone', $data->id) }}" method="post">
                            @csrf
                            <!--  Data existed update -->
                            @method('PUT')
                            <button type="submit" class="btn btn-warning">Undone</button>
                        </form>
                        @endif
                        {{-- Button edit --}}
                        <form action="{{ route('todos.edit', $data->id) }}" class="mx-3" method="post">
                            @csrf
                            @method('GET')
                            <button type="submit" class="btn btn-secondary text-light">Edit</a>
                        </form>
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






