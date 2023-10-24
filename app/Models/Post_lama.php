<?php

namespace App\Models;

class Post
{
    private static $blog_posts = [
        [
            "title" => "judul post pertama",
            "slug" => "judul-post-pertama",
            "author" => "gung andre",
            "body" => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nisi magnam cum sit architecto velit quibusdam mollitia saepe harum. Maiores ducimus, et exercitationem laborum amet pariatur adipisci. Rem quisquam corporis inventore."

        ],
        [
            "title" => "judul post kedua",
            "slug" => "judul-post-kedua",
            "author" => "andre",
            "body" => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nisi magnam cum sit architecto velit quibusdam mollitia saepe harum. Maiores ducimus, et exercitationem laborum amet pariatur adipisci. Rem quisquam corporis inventore."

        ]
    ];

    public static function all()
    {
        // karena property menggunakan method static jadi untuk memanggil variable tersebut harus di beri self

        // ! collection diunakan untuk membungkus array of data
        // ! dengan menggunakan collection kita bisa menggunakan method2 yang tersedia di collection tanpa perlu membuat sendiri
        return collect(self::$blog_posts);
    }

    public static function find($slug)
    {

        // ! pemanggilan valuenya menggunakan static karena merupakan method static dari collect()
        $posts = static::all();

        // ! contoh penggunaan method yang ada di dalam collection yaitu mengambil nilai berdasarkan kondisi yg di inginkan
        return $posts->firstWhere('slug', $slug);
    }
}
