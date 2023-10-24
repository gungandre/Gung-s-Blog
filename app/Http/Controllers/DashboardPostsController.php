<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // !menampilkan posts user yang sedang login
        return view('dashboard.posts.index', ['posts'  => Post::where('user_id', auth()->user()->id)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.posts.create', [

            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            'image' => 'image|file|max:1024',
            'body' => 'required'
        ]);

        if ($request->file('image')) {
            // ! fingsi store untuk menyimpan gambar di lokal kita yang secara default berada di folder storage, tetapi bisa di setting di folder config atau di env
            // ! lalu fungsi ini akan mengembalikan direktori file kita disimpan dan menginsert ke database
            $validatedData['image'] = $request->file('image')->store('post-image');
        }

        $validatedData['user_id'] = auth()->user()->id;


        // str limit untuk membatasi karakter yang di insert ke database
        // strip_tags untuk menghilangkan elemen html di post body
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);



        // Post::create($validatedData);


        // return ddd($validatedData);

        DB::table('posts')->insert([
            'title' => $validatedData['title'],
            "slug" => $validatedData['slug'],
            "category_id" => $validatedData['category_id'],
            "image" => $validatedData['image'],
            "body" => $validatedData['body'],
            "user_id" => $validatedData['user_id'],
            "excerpt" => $validatedData['excerpt'],
            "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
            "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),

        ]);

        return redirect('/dashboard/posts')->with('success', 'New post has been added!');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all()

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $rules = [
            'title' => 'required|max:255',
            'image' => 'image|file|max:1024',
            'category_id' => 'required',
            'body' => 'required'
        ];

        // ! validasi jika data slug yang di edit tidak sama di database maka di berivalidasi, jika tidak maka tidak di validasi
        if ($request->slug != $post->slug) {
            $rules['slug'] =  'required|unique:posts';
        }




        $validatedData = $request->validate($rules);


        if ($request->file('image')) {

            // ! menghapus image yang lama
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }


            // ! fingsi store untuk menyimpan gambar di lokal kita yang secara default berada di folder storage, tetapi bisa di setting di folder config atau di env
            // ! lalu fungsi ini akan mengembalikan direktori file kita disimpan dan menginsert ke database
            $validatedData['image'] = $request->file('image')->store('post-image');
        }

        $validatedData['user_id'] = auth()->user()->id;

        // str limit untuk membatasi karakter yang di insert ke database
        // strip_tags untuk menghilangkan elemen html di post body
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::where('id', $post->id)->update($validatedData);

        return redirect('/dashboard/posts')->with('success', 'New post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if ($post->image) {
            Storage::delete($post->image);
        }


        Post::destroy($post->id);

        return redirect('/dashboard/posts')->with('success', 'New post has been deleted!');
    }

    public function cekSlug(Request $request)
    {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->get('title'));
        return response()->json(['slug' => $slug]);
    }
}
