@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        Add new task
    </div>
    <div class="card-body">
        <form action="{{ route('todos.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Title</label>
                <input id="name" class="form-control" type="text" name="name" placeholder="Enter todo title">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input id="description" class="form-control" type="text" name="description" placeholder="Enter todo description">
            </div>
            <button type="submit" class="btn btn-success mt-3">Add</button>
        </form>
    </div>
</div>

@endsection