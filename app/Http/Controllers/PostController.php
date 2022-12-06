<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = DB::select('SELECT * FROM posts where id = :id', [
        //     'id' => 1
        // ]);
        // $posts = DB::insert('INSERT INTO posts (title, excerpt, body, image_path, is_published, min_to_read) values(?, ?, ?, ?, ?, ?)', [
        //     'Test', 'test', 'test', 'test', 1, 2
        // ]);

        // $posts = DB::update('UPDATE posts SET body = ? where id = ?', [
        //     'Body 2', 101
        // ]);

        // $posts = DB::update('DELETE from posts where id = ?', [101]);

        // $posts = DB::table('posts')
        // ->select('min_to_read')
        // ->distinct()
        // ->where('is_published', true)
        // ->where('id', '>', 50)
        // ->whereBetween('min_to_read', [2, 6])
        // ->whereNotBetween('min_to_read', [2, 6])
        // ->whereIn('min_to_read', [2, 6])
        // ->whereNull('excerpt')
        // ->orderBy('id', 'desc')
        // ->skip(30)
        // ->take(10)
        // ->inRandomOrder()
        // ->get();
        // ->where('id', 100)
        // ->first();
        // ->find(1);
        // ->where('id', 100)
        // ->value('body');
        // ->where('id', '>', 100)
        // ->count();
        // ->min('min_to_read');
        // ->,ax('min_to_read');
        // ->sum('min_to_read');
        // ->avg('min_to_read');

        // MODEL

        // $posts = Post::orderBy('id', 'desc')->take(10)->get();
        // $posts = Post::where('min_to_read', '!=', 2)->get();
        // $posts = Post::chunk(25, function ($posts) {
        //     foreach ($posts as $key => $post) {
        //         echo $post->title . PHP_EOL;
        //     }
        // });
        // $posts = Post::get()->count();
        // $posts = Post::min('min_to_read');
        // $posts = Post::max('min_to_read');
        $posts = Post::orderBy('updated_at', 'desc')->get();

        // dd($posts);
        return view('blog.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $post = new Post();
        // $post->title = $request->title;
        // $post->excerpt = $request->excerpt;
        // $post->body = $request->body;
        // $post->image_path = 'temporary';
        // $post->is_published = $request->is_published === 'on';
        // $post->min_to_read = $request->min_to_read;
        // $post->save();

        // dd($request);

        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'excerpt' => 'required',
            'body' => 'required',
            'image_path' => [
                'required',
                'mimes:jpeg,png,jpg',
                'max:5048'
            ],
            'min_to_read' => 'min:0|max:10'
        ]);

        Post::create([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'image_path' => $this->storeImage($request),
            'is_published' => $request->is_published === 'on',
            'min_to_read' => $request->min_to_read
        ]);

        return redirect('/blog');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = 1)
    {
        $post = Post::findOrFail($id);

        return view('blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('blog.edit', [
            'post' => Post::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:posts,title,' . $id,
            'excerpt' => 'required',
            'body' => 'required',
            'image_path' => [
                'mimes:jpeg,png,jpg',
                'max:5048'
            ],
            'min_to_read' => 'min:0|max:10'
        ]);
        $request->except(['_token', '_method']);
        Post::findOrFail($id)->update([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'body' => $request->body,
            'image_path' => $request->image_path,
            'is_published' => $request->is_published === 'on',
            'min_to_read' => $request->min_to_read
        ]);

        return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if(file_exists(public_path($post->image_path))) {
            unlink(public_path($post->image_path));
        }

        $post->delete();

        return redirect()->route('blog.index')->with('message', 'Post has been deleted successfully');
    }

    private function storeImage($request)
    {
        $newImageName = uniqid() . '-' . $request->title . "." . $request->image->extension();

        return $request->image->move(public_path('images'), $newImageName);
    }
}
