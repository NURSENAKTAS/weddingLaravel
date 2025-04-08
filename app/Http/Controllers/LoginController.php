<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login/login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([ //Input giriş kısımları için
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
        ]);

        // Kullanıcıyı e-posta ile ara
        $user = User::where('email', $request->email)->first(); //1. hangi sütun 2. hangi değer ilk geleni çek

        // Kullanıcıyı kontrol et ve şifreyi doğrula
        if ($user && Hash::check($request->password, $user->password)) { //Hash de gelen şifre ile veritabanından gelen şifre uyuşuyorsa
            // Oturum verileri
            Auth::login($user); //Tekrardan giriş kısmı yap.

            // Başarılı giriş için yönlendirme
            return redirect('/')->with('success', 'Başarıyla giriş yaptınız.');
        }
        //Eğer eşleşmezse zaten direkt çıkış durumuna gönder
        // Hatalı giriş durumunda
        return back()->withErrors([
            'email' => 'E-posta adresi veya şifre hatalı.', //Hatayı burada döndür
        ])->withInput($request->only('email')); //Sadece input kısmında mail kısmını boş bırakma
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); //Oturumda saklanan tüm verileri siliyor
        $request->session()->regenerateToken(); //Güvenlik için tekrartoken

        return redirect('/')->with('success', 'Başarıyla çıkış yaptınız.');
    }
}
