<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pastalar;
use App\Models\Menu_ogeleri;
use App\Models\Mekanlar;
use App\Models\Suslemeler;
use App\Models\Organizasyonlar;
use App\Models\Iletisim;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // Veritabanından 3 pasta çek
        $pastalar = Pastalar::take(3)->get();
        foreach ($pastalar as $key => $pasta) {
            // Eğer veritabanında resim_url tanımlı değilse, varsayılan bir değer ata
            if (empty($pasta->resim_url)) {
                $pasta->resim_url = "pasta" . ($key + 1) . ".jpg";
            }
        }

        // Veritabanından 3 menü öğesi çek
        $menuOgeleri = Menu_ogeleri::take(3)->get();
        foreach ($menuOgeleri as $key => $menu) {
            if (empty($menu->resim_url)) {
                $menu->resim_url = "yemek" . ($key + 1) . ".jpg";
            }
        }

        // Veritabanından 3 mekan çek
        $mekanlar = Mekanlar::take(3)->get();
        foreach ($mekanlar as $key => $mekan) {
            if (empty($mekan->resim_url)) {
                $mekan->resim_url = "mekan" . ($key + 1) . ".jpg";
            }
        }

        // Veritabanından 3 süsleme çek
        $suslemeler = Suslemeler::take(3)->get();
        foreach ($suslemeler as $key => $susleme) {
            if (empty($susleme->resim_url)) {
                $index = $key + 1;
                if ($index == 2) {
                    $susleme->resim_url = "süslemler2.jpg";
                } else {
                    $susleme->resim_url = "süslemeler" . $index . ".jpg";
                }
            }
        }

        // Veritabanından 4 organizasyon çek
        $organizasyonlar = Organizasyonlar::take(4)->get();
        $defaultOrganizasyonResimleri = [
            "ozelpartiler.jpg",
            "nisan.jpg",
            "birtday.jpg",
            "Wedding Lights.jpg"
        ];

        foreach ($organizasyonlar as $key => $organizasyon) {
            if (empty($organizasyon->resim_url) && isset($defaultOrganizasyonResimleri[$key])) {
                $organizasyon->resim_url = $defaultOrganizasyonResimleri[$key];
            }
        }

        return view("index", [
            'pastalar' => $pastalar,
            'menuOgeleri' => $menuOgeleri,
            'mekanlar' => $mekanlar,
            'suslemeler' => $suslemeler,
            'organizasyonlar' => $organizasyonlar
        ]);
    }

    public function iletisimGonder(Request $request)
    {
        // Form validasyonu
        $validated = $request->validate([
            'ad_soyad' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'konu' => 'required|string|max:255',
            'mesaj' => 'required|string'
        ], [
            'ad_soyad.required' => 'Ad ve soyad bilgisi gereklidir',
            'email.required' => 'E-posta adresi gereklidir',
            'email.email' => 'Geçerli bir e-posta adresi giriniz',
            'konu.required' => 'Konu bilgisi gereklidir',
            'mesaj.required' => 'Mesaj içeriği gereklidir'
        ]);

        // Veritabanına kaydet
        $iletisim = Iletisim::create([
            'ad_soyad' => $validated['ad_soyad'],
            'email' => $validated['email'],
            'konu' => $validated['konu'],
            'mesaj' => $validated['mesaj'],
            'durum' => 'beklemede', // Varsayılan durum
            'kullanici_id' => Auth::check() ? Auth::id() : null, // Giriş yapmış kullanıcıysa ID'sini kaydet
            'olusturulma_tarihi' => now()
        ]);

        return redirect()->back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede sizinle iletişime geçeceğiz.');
    }
}
