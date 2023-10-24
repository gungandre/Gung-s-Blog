<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;

use Illuminate\Database\Seeder;
// ! seeder digunakan untuk membuat data dumy atau data contoh untuk di masukan ke dalam database saat kita melakukan migrate\
// ! karena migrate menghapus semua data
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'gungandre',
            'username' => 'gungandre',
            'email' => 'gungandre@gmail.com',
            'is_admin' => true,
            'password' => bcrypt('123456')
        ]);

        // User::create([
        //     'name' => 'handre',
        //     'email' => 'handre@gmail.com',
        //     'password' => bcrypt('123456')
        // ]);
        // ! contoh penggunaan factory
        User::factory(3)->create();

        Category::create([
            'nama' => 'Web Design',
            'slug' => 'web-design'
        ]);

        Category::create([
            'nama' => 'Programming',
            'slug' => 'programming'
        ]);


        Post::factory(20)->create();



        // Post::create([
        //     'title' => 'Judul Pertama',
        //     'category_id' => 1,
        //     'user_id' => 1,
        //     'slug' => 'judul-pertama',
        //     'excerpt' => 'lorem imsum',
        //     'body' => 'loremfa-rotate-270vwrvwrvnwrjbvjwrboiwrnbnwrlnbowrboirwoibrnbnwroibwru2ohbiornbrwnobrwhowrnibowribwrnowbr'
        // ]);

        // Post::create([
        //     'title' => 'Judul Kedua',
        //     'category_id' => 2,
        //     'user_id' => 1,
        //     'slug' => 'judul-kedua',
        //     'excerpt' => 'lorem imsum',
        //     'body' => 'loremfa-rotate-270vwrvwrvnwrjbvjwrboiwrnbnwrlnbowrboirwoibrnbnwroibwru2ohbiornbrwnobrwhowrnibowribwrnowbr'
        // ]);

        // Post::create([
        //     'title' => 'Judul Ketiga',
        //     'category_id' => 3,
        //     'user_id' => 1,
        //     'slug' => 'judul-ketiga',
        //     'excerpt' => 'lorem imsum',
        //     'body' => 'loremfa-rotate-270vwrvwrvnwrjbvjwrboiwrnbnwrlnbowrboirwoibrnbnwroibwru2ohbiornbrwnobrwhowrnibowribwrnowbr'
        // ]);

        // Post::create([
        //     'title' => 'Judul Keempat',
        //     'category_id' => 3,
        //     'user_id' => 2,
        //     'slug' => 'judul-keempat',
        //     'excerpt' => 'lorem imsum',
        //     'body' => 'loremfa-rotate-270vwrvwrvnwrjbvjwrboiwrnbnwrlnbowrboirwoibrnbnwroibwru2ohbiornbrwnobrwhowrnibowribwrnowbr'
        // ]);
    }
}
