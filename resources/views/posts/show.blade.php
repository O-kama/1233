@extends('layouts.layouts', ['title' => "Пост №$post->post_id. $post->title"])


@section('content')

    <div class="col-12 card my-3">
        <div class="card-body">

            <div class="card-top">
                <h3 class="card-title">{{ $post->title }}</h3>
                <p class="card-text">{{ $post->desc }}</p>
                <img src="{{$post->img}} ">
                <div class="card-author">Автор: {{$post->name}}</div>
                {{$post->created_at->diffForHumans()}}
            </div>

            <div class="card-info coments">
                {{--                    <div class="col my-5  ">--}}
                @foreach($comments as $comment)
                    <div class="col card my-3">
                        <div class="card-body">
                            <div class="card-top">
                                <p class="card-text">{{ $comment->desc }}</p>
                                <img src="{{$comment->img}} ">
                            </div>
                            <div class="card-info">
                                @auth
                                    @if(Auth::user()->id == $comment->author_id)
                                        <form action="{{route('comment.destroy', ['id' => $comment->comment_id])}}"
                                              method="post"
                                              onsubmit="if (confirm('Точно удалить ?')) {return true} else {return false}">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-outline-info" value="Удалить">
                                        </form>
                                        <!-- удалить коментарий  -->
                                    @endif
                                @endauth
                            </div>
                        </div>

                        {{$comment->name}} -
                    {{$comment->created_at->diffForHumans()}}
                    <!-- имя и время  -->
                    </div>
                @endforeach
                {{--                    </div>--}}

                <div class="coment coment_bar d-flex">
                @auth()
                        <form action="{{route('comment.store')}}" method="post" enctype="multipart/form-data" class="an-form">
                            @csrf
                            <input type="hidden" name="post" value="{{$post->post_id}}">
                            <textarea name="message" placeholder="ваше сообщение" class="mesage-tex"></textarea>
                            <!-- /.btn -->
                            <input name="img" type="file">
                            <input type="submit" value="Отправить Сообщение" class="btn btn-outline-secondary">
                        </form>
                @endauth
                <!-- /.Блок отправки сообщения  -->
                </div>
            </div>
        </div>
        <a href="{{route('post.index')}}" class="btn btn-outline-info mb-3 btn-show">На главную</a>
        @auth()
            @if(Auth::user()->id == $post->author_id)
                <a href="{{route('post.edit', ['id' => $post->post_id])}}"
                   class="btn btn-outline-info btn-show"  >Редактировать</a>
                <form action="{{route('post.destroy', ['id' => $post->post_id])}}" method="post"
                      onsubmit="if (confirm('Точно удалить ?')) {return true} else {return false}">
                    @csrf
                    @method('DELETE')
                    <input type="submit"  class="btn btn-outline-info btn-show "  value="Удалить">
                </form>
            @endif
        @endauth
    </div>



@endsection
