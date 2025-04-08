<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Kullanıcı giriş yapmamışsa login sayfasına yönlendir
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Kullanıcının rolünü kontrol et - sadece Admin veya Yönetici rolündeki kullanıcılar panele erişebilir
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'yonetici') {
            return redirect('/')->with('error', 'Yönetim paneline erişim yetkiniz bulunmamaktadır.');
        }

        return $next($request); //Eğer her şey yolundaysa normal akışında devam etsin panel kısmına girilmesine izin verilsin
    }
}
