<?php

// cara membuat controller seperti ini
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{


    public function index()
    {

        $title = '';
        if (request('category')) {
            $category = Category::firstWhere('slug', request('category'));
            $title = ' in ' . $category->nama;
        }

        if (request('authors')) {
            $authors = User::firstWhere('username', request('authors'));
            $title = ' by ' . $authors->name;
        }

        //! sebenarnya urusan kueri ke database itu dari model
        //! code pencarian posts ini bisa kita pindahkan ke dalam model di Post menggunakan scope model



        $posts = Post::with(['author', 'category'])->latest();

        // if ($request->input('search') != '') {
        //     $posts->where('title', 'like', '%' . $request->input('search') . '%')->orWhere('body', 'like', '%' . $request->input('search') . '%');
        // }

        // latest digunakan untuk mengurutkan data dari yang terbaru berada paling atas\
        // cara mengatasi problem n+1 dengan menggunakan method with.

        //! memanggilan scope model hanya perlu nama scopenya saja, contoh di model nama scopenya adalah scopeFilter, disini kita hanya perlu memanggil filter saja

        //! untuk membuat pagination, cukup menggunakan method paginate() karna laravel sudah membuatkannya dan bisa melakukan next menggunakan query params page

        //! withQueryString agar saat kita melakukan pencarian atau filter dan klik paginationnya, params tidak tereset
        return view('posts', ["title" => "All Blog" . $title, "active" => "posts", "posts" => $posts->filter(request(['search', 'category', 'authors']))->paginate(7)->withQueryString()]);
    }
    // sebelumnya menggunakan method Post::find() untuk mencaro data berdasarkan id, dengan mengirimkan langsung model post nya id parameter jadi tidak perlu lagi
    // parameter dari show() langsung dari model post, jadi tidak perlu lagi query data

    public function show(Post $post)
    {
        return  view('post', ["title" => "single post", "active" => "posts", "post" => $post]);
    }
}
