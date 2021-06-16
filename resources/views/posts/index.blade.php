@extends('layouts.layouts', ['title' => "Главная страница"])


@section('content')
<div class="container-fluid">

    @if(isset($_GET['search']))
        @if(count($posts)>0)
            <h2>Результаты поиска по запросу "<?$_GET['search']?>"</h2>
            <p class="lead">Всего найдено {{count($posts)}} постов</p>
        @else
            <h2>По запросу "<?$_GET['search']?>"Ничего не найдено</h2>
            <a href="{{route('post.index')}}" class="btn-outline-primary">посмотреть все посты</a>
        @endif
    @endif

    <div class="row my-5 main-cards">
        @foreach($posts as $post)
            <div class="col-2 card m-3">
                <div class="card-body">
                    <div class="card-top">
                        <h3 class="card-title">{{ $post->title }}</h3>
                        <p class="card-text">{{ $post->desc }}</p>
                        <img src="{{$post->img}}" alt="">
                    </div>
                    <div class="card-info">
                        <div class="card-author">
                            Автор: {{$post->name}} <br>
                            {{$post->created_at->diffForHumans()}}
                        </div>
                        <a href="{{route('post.show',['id' => $post->post_id]) }}" class="btn btn-outline-info bottom-element">Войти в беседу</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if(!isset($_GET['search']))
    {{$posts->links()}}
        @endif

@endsection
