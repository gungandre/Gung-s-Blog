<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //!  method up digunakan untuk membuat scema atau struktur dari tabelnya
    public function up()
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    // ! untuk emnghilangkan scema yang kita buat 
    // ! untuk menjalankannya menggunakan php artisan migration:rollback

    // ! jika ingin melakukan rollback dan migarte bisa menggunakan php artisan migrate:fresh
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
}
