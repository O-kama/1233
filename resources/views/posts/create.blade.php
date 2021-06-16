@extends('layouts.layouts', ['title' => "Главная страница"])

@section('content')

    <form action="{{route('post.store')}}" method="post" enctype="multipart/form-data">
    @csrf
        <h2>Создать беседу</h2>
        @include('posts.parts.post')
        <input type="submit" value="Создать беседу" class="btn btn-outline-secondary" >
    </form>

@endsection
