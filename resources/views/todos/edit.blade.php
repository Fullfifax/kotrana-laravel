@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Edit task <span class="badge bg-secondary">#{{ $todo->id }}</span></h4>
    </div>
    <div class="card-body">
        <form action="{{ route('todos.update', $todo->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Title</label>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $todo->name) }}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input id="description" class="form-control" type="text" name="description" value="{{ old('description', $todo->description) }}">
            </div>
            <div class="form-group">
                <input id="done" class="form-check-input" type="checkbox" name="done" {{ $todo->done ? 'checked' : '' }} value=1>
                <label class="form-check-label" for="done">Done ?</label>
            </div>
            <button type="submit" class="btn btn-success mt-3">Update</button>
        </form>
    </div>
</div>

@endsection