<?php

namespace App\Models;

use App\Models\Category;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Cviebrock\EloquentSluggable\Sluggable;


class Post extends Model
{
    use HasFactory, Sluggable;
    // $fillable digunakan untuk fill mana saja yang boleh di isi
    protected $fillable = ['title', 'excerpt', 'slug', 'body', 'category_id', 'user_id'];
    //  ! guarded kebalikan dari fillable yaitu fild mana yg tidak boleh disii
    // protected $guarded = []


    // ! ini adalah libary slugable untuk membuat slug secara otomatis saat kita mengtik slug
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    // ! jika ingin membuat forent key nama fiend di database harus sama dengan nama method forend keynya, contoh method di category di bawah berelasi dengan field category_id yang laravel sudah tau, karena menggunakan cara route model binding yang mencari sesuai dengan namaa methodnya, jika ingin mengubah namanya tidak sesuai dengan field di database bisa menggunakan cara di author di bawah
    public function category()
    {
        // cara merelasikan tabel post dan kategory
        return $this->belongsTo(Category::class);
    }
    public function author()
    {
        //! kita bisa menggunakan method authors asalkan kita mengisi parameter kedua di function belongto nama field forent key kita (user_id)
        return $this->belongsTo(User::class, 'user_id');
    }

    //! ini cara menggunakan scope model untuk pencarian search
    //! jika ingin membuat scope model harus di awali dengan nama scope lalu setelahnya bebas

    public function scopeFilter($query, array $filters)
    {

        // ! ini adalah pengecekan dengan cara tradisional, di laravel ada pengecekan yang lebih ringkas dengan method when()
        // if (isset($filters['search']) ? $filters['search'] : false) {
        //     return  $query->where('title', 'like', '%' . $filters['search'] . '%')->orWhere('body', 'like', '%' . $filters['search'] . '%');
        // }


        //! sintaks ?? digunakan untuk menggantikan isset dan menggunakan ternary operator
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return  $query->where('title', 'like', '%' . $search . '%')->orWhere('body', 'like', '%' . $search . '%');
        });

        //! menambahkan query filter jika pencarian posts berdasarkan category
        //! ajaibnya di laravel jika pencarian berdasarkan search/category maka dijalankan query di 1 query saja, jika pencarian berdasarkan keduanya maka query filter category dan search dijalankan

        //! saat quert category memerlukan relasi, maka kita perlu memberi tahu laravel bahwa ini adalah queri relasi dengan cara menggunakan method hasMany, lalu paramternya kita bisa berikan method relasi yang sudah kita buat diatas yaitu public function category()
        $query->when($filters['category'] ?? false, function ($query, $category) {
            return  $query->whereHas('category', function ($query) use ($category) {
                //! di dalam php kita tidak bisa memanggil variable di closure function, maka dari itu kita perlu menggunakan use untuk memanggillnya saat membuat closure function
                $query->where('slug', $category);
            });
        });

        $query->when($filters['authors'] ?? false, function ($query, $author) {
            return  $query->whereHas('author', function ($query) use ($author) {
                //! di dalam php kita tidak bisa memanggil variable di closure function, maka dari itu kita perlu menggunakan use untuk memanggillnya saat membuat closure function
                $query->where('username', $author);
            });
        });
    }

    public function getRouteKeyName()
    {
        // ! method ini berfungsi agar saat menggunakan route model binding parameter pencariannya di database menggunakan slug, karna secara default eloquen pencariannya menggunakan id
        return 'slug';
    }
}
