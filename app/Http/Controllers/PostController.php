<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @param PostRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->search){
            $posts = Post::join('users', 'author_id', '=', 'users.id')
                ->where('title', 'like', '%'. $request->search.'%')
                ->orWhere('desc', 'like', '%'. $request->search.'%')
                ->orWhere('name', 'like', '%'. $request->search.'%')
                ->orderBy('posts.created_at','desc')
                ->get();
            return view('posts.index', compact('posts'));
        }

        $posts = Post::join('users', 'author_id', '=', 'users.id')
            ->orderBy('posts.created_at','desc')
            ->paginate(20);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->desc = $request->desc;
        $post->author_id = \Auth::user()->id;

        if ($request->file('img')){
            $path = Storage::putFile('public', $request->file('img'));
            $url = Storage::url($path);
            $post->img = $url;
        }

        $post->save();

        return  redirect()->route('post.index')->with('success', 'Пост успешно создан');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::join('users', 'author_id', '=','users.id')
            ->find($id);
        $comments = Comment::join('users', 'author_id', '=', 'users.id')->where('posted_in', $id)->get();
        return view('posts.show', compact('post','comments'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);

        if ($post->author_id != \Auth::user()->id){
          return redirect()->route('post.index')->withErrors('Вы не можете редактировать данный пост');
        }

        $post->title = $request->title;
        $post->desc = $request->desc;

        if ($request->file('img')) {
            $path = Storage::putFile('public', $request->file('img'));
            $url = Storage::url($path);
            $post->img = $url;
        }

        $post->update();
        $id = $post->post_id;
        return redirect()->route('post.show', compact('id'))->with('success', 'Успешно отредактровано !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post->author_id != \Auth::user()->id){
            return redirect()->route('post.index')->withErrors('Вы не можете удалить данный пост');
        }
        $post->delete();
        return redirect()->route('post.index')->with('success', 'Удалено!');
    }

    public function  comment(Request $request)
    {
        $post = new Comment();
        $post->desc = $request->message;
        $post->posted_in = $request->post;
        $post->author_id = \Auth::user()->id;

        if ($request->file('img')){
            $path = Storage::putFile('public', $request->file('img'));
            $url = Storage::url($path);
            $post->img = $url;
        }

        $post->save();

        return  redirect()->route('post.show',$request->post);

    }

    public function destroycomment($id)
    {
        $post = Comment::find($id);
        if ($post==null || $post->author_id != \Auth::user()->id){
            return redirect()->route('post.index')->with('error', 'нет доступа!');
        }
        $post->delete();
        return redirect()->route('post.show',['id'=>$post->posted_in])->with('success', 'Удалено!');
    }
}
