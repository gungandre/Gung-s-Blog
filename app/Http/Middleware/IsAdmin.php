<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        // ! disini logika middleware di buat
        // ! setelah middleware dibuat kita perlu mengkonfigurasi middleware kita agar bisa digunakan di kernel.php

        if (auth()->guest() || auth()->user()->is_admin !== 1) {
            //! mengecek jika user tidak login dan jika sudah login user bukan gungandre
            abort(403);
        }


        return $next($request);
    }
}
