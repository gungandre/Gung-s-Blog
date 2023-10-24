<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

// ! factory digunakan untuk membuat data dummy atau data contoh ke dalam database dengan menggunakan library faker
// ! kita harus setup data yg ingin di tambahkan di method definition
// ! lalu factory tersebut bisa di jalankan di seeder
// ! nama factory harus sama dengan nama model dan di akhiri dengan Factory

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    // ! seacara default faker->paragraphs adalah array
    // ! jika kita ingin membungkus setiap paragraf ke elemen p maka kita bisa mengloopingnya lalu hasilnya simpan ke database sepeti yang ada di dalam onbject body
    {
        return [
            'title' => $this->faker->sentence(mt_rand(2, 8)),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->paragraph(),
            'body' => collect($this->faker->paragraphs(mt_rand(5, 10)))->map(function ($p) {
                return "<p>$p</p>";
            })->implode(''),
            'user_id' => mt_rand(1, 3),
            'category_id' => mt_rand(1, 2)
        ];
    }
}
