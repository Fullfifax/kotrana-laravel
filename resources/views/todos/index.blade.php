@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($datas as $data)
            <div class="alert alert-primary" role="alert">    
                {{ $data->name }}
                @if($data->done)
                    <span class="badge bg-success text-light">done</span>
                @endif
            </div>
        @endforeach
        {{ $datas->links("pagination::bootstrap-4") }}
    </div>

@endsection






