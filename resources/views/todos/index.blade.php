@extends('layouts.app')
@section('content')
@foreach ($datas as $data)
    <h4>{{ $data->name }}</h4>
@endforeach
@endsection






