<?php

use App\Http\Controllers\AdminCategoryController;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

use App\Http\Controllers\DashboardPostsController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home', ["title" => "home", "active" => "home", 'active' => 'home']);
});

Route::get('/about', function () {
    return view('about', ["nama" => "Gung Andre", "active" => "about", "email" => "gungandre@gmail.com", "image" =>  "foto.png", "active" => "about", "title" => "about"]);
});


// !cara pemanggilan controller mempunyai 2 paraeter yaitu nama classnya dan methodnya
Route::get('/blog', [PostController::class, 'index']);

// halaman sigle blog
// post:slug digunakan untuk mengirim parameter berupa slug yang ada di database, lalu di controller akan mengolahnya dengan model yg sesuai dengan post
Route::get('blog/{post:slug}', [PostController::class, 'show']);

Route::get('categories/', function (Category $category) {
    return view('categories', ['title' => 'Post Categories', 'active' => 'categories', 'categories' => Category::all()]);
});


Route::get('categories/{category:slug}', function (Category $category) {
    return view('posts', ['title' => "Posts By Category : $category->nama", 'posts' => $category->posts->load('category', 'author'), 'active' => 'categories'],);
});

Route::get('/authors/{author:username}', function (User $author) {
    // ! ini adalah route model binding yang membuat parameter {author:username}, jadi secara default jika kita menggunakan author saja sebagai parameternya maka data yg di panggil oleh model berdasarkan id, maka dari itu kita perlu menambahkan author:username untuk mencari derdasarkan username


    // ! cara mengatasi n+! problem menggunakan route model binding dengan menambahkan method load
    return view('posts', ['title' => "Post By Author : $author->name", 'posts' => $author->posts->load('category', 'author'), 'active' => 'categories']);
});


//! di laravel kita bisa menamakan route kita dengan menggunakan method name()
// ! jadi nanti kita bisa menggunakan nama tersebut untuk memanggil route di codingan

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);


//! fungsi midleware(auth) digunakan hanya user yg sudah login yg bisa mengakses route ini, jika guest sebaliknya
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth');


Route::get('/dashboard/posts/cekSlug', [DashboardPostsController::class, 'cekSlug']);
//! route resource untuk menangani crud yang sudah di sediakan oleh laravel tanpa perlu membuat manual
//! untuk melihat route dari resouce bisa menggunakan php artisan route:list
Route::resource('/dashboard/posts', DashboardPostsController::class)->middleware('auth');


//! method except digunakan untuk pengecualian method resource, yang mana ini adalah mmethod show di admicategorycontroller

//! kita ingin route dashboard/categories hanya bisa di akses oleh admin
// ! untuk membuat itu kita perlu membuat authorization dengan menggunakan middleware
// ! kita bisa membuat middleware sendiri dengan mengetik php artisan make middleware
// ! file middleware bisa di akses di folder middleware
//? Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('is_admin');

//! tapi ada cara yang lebih ferksibel lagi selain menggunakan middleware, yaitu menggunakan gate
//! untuk menggunakan gate kita definisikan dlu di dalam file appserviceprovider di method boot() yang dijalankan saat app berjalan 
Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show')->middleware('is_admin');
