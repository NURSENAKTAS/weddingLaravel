<?php

namespace App\Http\Controllers;

use App\Models\mekan_randevu;
use App\Models\Mekanlar;
use App\Models\Suslemeler;
use App\Models\Pastalar;
use App\Models\Menu_ogeleri;
use App\Models\Organizasyonlar;
use App\Models\Randevu;
use App\Models\Rezervasyonlar;
use App\Models\Paketler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RandevuController extends Controller
{
    public function randevu()
    {
        // Tüm mekanları, süslemeleri, yemekleri, pastaları ve organizasyon türlerini veritabanından çekelim
        $mekanlar = Mekanlar::all();
        $suslemeler = Suslemeler::all();
        $yemekler = Menu_ogeleri::all();
        $pastalar = Pastalar::all();
        $organizasyonlar = Organizasyonlar::all();

        // Kullanıcı giriş yapmış mı kontrol et
        $kullanici = null;
        if (Auth::check()) {
            $kullanici = Auth::user();
        }

        // Dolu tarihleri çek - Onaylandı ve Beklemede durumundaki randevuların tarihleri
        // İlişkiyi kullanarak doğrudan JOIN ile verimli sorgu
        $doluTarihler = DB::table('randevus')
            ->join('rezervasyonlars', 'randevus.id', '=', 'rezervasyonlars.randevu_id')
            ->whereIn('rezervasyonlars.rezervasyon_durum', ['Onaylandı', 'Beklemede'])
            ->select('randevus.randevu_tarihi')
            ->get()
            ->map(function($item) {
                return Carbon::parse($item->randevu_tarihi)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->all();

        // JSON formatına çevir
        $doluTarihlerJSON = json_encode($doluTarihler);

        // View'a tüm verileri gönderelim
        return view('randevu', compact('mekanlar', 'suslemeler', 'yemekler', 'pastalar', 'organizasyonlar', 'kullanici', 'doluTarihlerJSON'));
    }

    /**
     * Yeni randevu ve rezervasyon oluşturur
     */
    public function store(Request $request)
    {
        // Form verilerini doğrulama
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date',
            'time' => 'required',
            'package' => 'required|string',
            'event_type' => 'required',
            'venue' => 'required', //mekan
            'decoration' => 'required',
            'menu' => 'required',
            'cake' => 'required',
            'message' => 'nullable|string',
            'total-price' => 'nullable|string'
        ]);

        // Kullanıcı giriş yapmış mı kontrol et
        $userId = Auth::check() ? Auth::id() : null;

        // Randevu tarihini ve saatini birleştir
        $randevuDateTime = $validatedData['date'] . ' ' . $validatedData['time'] . ':00';

        // Temel fiyatı hesapla
        $temelFiyat = $this->calculateBasePrice($validatedData['package']);
        $toplamFiyat = $validatedData["total-price"];
        
        // Tüm kayıtlar için aynı zaman bilgisini kullan
        $currentTime = Carbon::now();

        // DB transaction başlat
        DB::beginTransaction(); // DB birden fazla ortak anahtar olduğu için hepsi gerçekleşesiye kadar bekle
        //paranın çıktığı an ve başka hesaba girdiği anı düşün o zamana kadar bekliyor

        try {
            // 1. Paket oluştur
            $paket = Paketler::create([
                'organizasyon_id' => $this->getOrganizasyonId($validatedData['event_type']),
                'mekan_id' => $validatedData['venue'], //mekan
                'susleme_id' => $validatedData['decoration'],
                'menu_ogeleri_id' => $validatedData['menu'],
                'pasta_id' => $validatedData['cake'],
                'paket_adi' => $this->getPaketAdi($validatedData['package']),
                'temel_fiyat' => $temelFiyat,
                'ekstra_fiyat' => $toplamFiyat - $temelFiyat,
                'olusturulma_tarihi' => $currentTime,
                'guncellenme_tarihi' => $currentTime
            ]);

            // 2. Randevu oluştur
            $randevu = Randevu::create([
                'kullanici_id' => $userId ?? 1,
                'paket_id' => $paket->id,
                'randevu_türü' => strtolower($validatedData['event_type']),
                'randevu_tarihi' => $randevuDateTime,
                'ozel_istekler' => $validatedData['message'],
                'olusturulma_tarihi' => $currentTime,
                'guncelleme_tarihi' => $currentTime
            ]);

            // 3. Rezervasyon oluştur
            $rezervasyon = Rezervasyonlar::create([
                'randevu_id' => $randevu->id,
                'rezervasyon_durum' => 'Beklemede',
                'olusturulma_tarihi' => $currentTime,
                'guncelleme_tarihi' => $currentTime
            ]);

            $mekan_randevu = mekan_randevu::create([
                'mekan_id' => $validatedData['venue'],
                'randevus_id' => $randevu->id,
            ]);

            DB::commit(); //Burada hem para çıktı hem para girdi işlemi onaylandı diyor

            // Başarılı işlem sonrası aynı sayfaya yönlendirme
            return redirect()->route('randevu')
                            ->with('success', 'Rezervasyon başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            DB::rollBack(); //Yapılan tüm değişiklikleri geri alıyor eğer para çıktı ama girmediyse parayı eski haline getirio

            // Hata durumunda kullanıcıyı bilgilendir
            return redirect()->route('randevu')
                            ->with('error', 'Rezervasyon oluşturulurken bir hata oluştu.')
                            ->withInput();
        }
    }

    /**
     * Paket tipine göre temel fiyatı belirler
     */
    private function calculateBasePrice($packageType)
    {
        switch ($packageType) {
            case 'ekonomik':
                return 150000;
            case 'standart':
                return 250000;
            case 'premium':
                return 350000;
            case 'ozel':
                return 100000;
            default:
                return 0;
        }
    }

    private function getPaketAdi($packageType)
    {
        switch ($packageType) {
            case 'ekonomik':
                return 'Ekonomik Paket';
            case 'standart':
                return 'Standart Paket';
            case 'premium':
                return 'Premium Paket';
            case 'ozel':
                return 'Özel Paket';
            default:
                return 'Belirtilen Paket';
        }
    }

    private function getOrganizasyonId($eventType)
    {
        // Organizasyon türüne göre ID bul
        $organizasyon = Organizasyonlar::where('organizasyon_türü', $eventType)->first();
        return $organizasyon ? $organizasyon->id : 1; // Bulunamazsa varsayılan 1
    }
}
