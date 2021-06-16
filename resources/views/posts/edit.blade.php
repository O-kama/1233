@extends('layouts.layouts', ['title' => "Редактировагие поста №$post->post_id. $post->title"])

@section('content')

    <form action="{{route('post.update', ['id'=>$post->post_id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h2>Создать беседу</h2>
        @include('posts.parts.post')

        <input type="submit" value="Редактировать беседу" class="btn btn-outline-secondary" >
    </form>

@endsection
