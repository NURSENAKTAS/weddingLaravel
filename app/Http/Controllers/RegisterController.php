<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('login/register');
    }

    public function register(Request $request)
    {
        // Form verilerini doğrula
        $validated = $request->validate([
            'kulad' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^[0-9\s\-\(\)]{10,15}$/'], //Regex 10 ile 15 arasında sayıya izin verir ve rakamlara izin verir
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'kulad.required' => 'Ad Soyad alanı zorunludur.',
            'phone.required' => 'Telefon numarası zorunludur.',
            'phone.regex' => 'Geçerli bir telefon numarası giriniz.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılıyor.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarı eşleşmiyor.',
        ]);

        // Yeni kullanıcı oluştur
        $user = User::create([ //Users da veritabanına kayıt işlemi açıyoruz
            'name' => $validated['kulad'],
            'phone' => $validated['phone'],
            'role' => 'Kullanıcı', // Varsayılan olarak user rolü
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Kullanıcıyı otomatik giriş yap
        Auth::login($user); //Mevcut kullanıcıyı giriş yaptır Auth ile

        // Ana sayfaya yönlendir
        return redirect('/')->with('success', 'Hesabınız başarıyla oluşturuldu.'); //Session da success başarılı olarak oluşturuldu yazdır
    }
}
