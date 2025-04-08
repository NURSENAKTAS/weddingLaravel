<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Randevu;
use App\Models\User;
use App\Models\Rezervasyonlar;
use App\Models\Odemeler;
use App\Models\mekan_randevu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRandevuController extends Controller
{
    public function index()
    {
        // Tüm randevuları çek, en yeniler üstte olacak şekilde
        $randevular = Randevu::with(['kullanici', 'Rezervasyonlar'])->orderBy('olusturulma_tarihi', 'desc')->get();
        // İlişki zaten with() ile çekildiği için ayrı bir sorguya gerek yok
        // $rezeervasyonlar = Rezervasyonlar::where($randevular->id,$rezeervasyonlar->randevu_id);

        foreach ($randevular as $key => $randevu) {
            // Rezervasyon durumunu kontrol et (varsa)
            if ($randevu->Rezervasyonlar->count() > 0) {
                $durum = $randevu->Rezervasyonlar->first()->rezervasyon_durum;

                if($durum == "Onaylandı") {
                    $randevu->rezervasyon_durum = "onaylandı";
                }
                else if($durum == "Başarısız") {
                    $randevu->rezervasyon_durum = "reddedildi";
                }
                else if($durum == "İptal Edildi") {
                    $randevu->rezervasyon_durum = "iptal";
                }
                else if($durum == "Beklemede") {
                    $randevu->rezervasyon_durum = "beklemede";
                }
                else {
                    $randevu->rezervasyon_durum = "onaylandi";
                }
            } else {
                // Rezervasyon yoksa varsayılan durum
                $randevu->rezervasyon_durum = "beklemede";
            }
        }
        return view("panel.appointments", compact('randevular'));
    }

    public function goruntule($id)
    {
        $randevu = Randevu::with(['kullanici', 'Rezervasyonlar'])->findOrFail($id);
        return view('panel.randevu_detay', compact('randevu'));
    }

    public function durumGuncelle(Request $request, $id)
    {
        $randevu = Randevu::with('Rezervasyonlar')->findOrFail($id);

        // Gelen durum değerini veritabanındaki enum değerlerine dönüştür
        $durumDegeri = $request->durum;
        switch($durumDegeri) {
            case 'onaylandi':
                $durumDegeri = 'Onaylandı';
                break;
            case 'beklemede':
                $durumDegeri = 'Beklemede';
                break;
            case 'reddedildi':
                $durumDegeri = 'Başarısız';
                break;
            case 'iptal':
                $durumDegeri = 'İptal Edildi';
                break;
            default:
                $durumDegeri = 'Beklemede';
        }

        try {
            // Randevuya ait rezervasyon var mı kontrol et
            if ($randevu->Rezervasyonlar->count() > 0) {
                // Varsa ilk rezervasyonun durumunu güncelle
                $rezervasyon = $randevu->Rezervasyonlar->first();
                $rezervasyon_id = $rezervasyon->id;

                // Model üzerinden güncelleme
                $rezervasyon->rezervasyon_durum = $durumDegeri;
                $rezervasyon->save();

                // Alternatif olarak direkt DB facade ile güncelleme
                DB::table('rezervasyonlars')
                    ->where('id', $rezervasyon_id)
                    ->update(['rezervasyon_durum' => $durumDegeri]);
            } else {
                // Yoksa yeni bir rezervasyon oluştur
                $rezervasyon = new Rezervasyonlar();
                $rezervasyon->randevu_id = $randevu->id;
                $rezervasyon->rezervasyon_durum = $durumDegeri;
                $rezervasyon->save();

                // Alternatif olarak direkt DB facade ile ekleme
                DB::table('rezervasyonlars')->insert([
                    'randevu_id' => $randevu->id,
                    'rezervasyon_durum' => $durumDegeri,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return redirect()->route('appointments')->with('success', 'Randevu durumu başarıyla güncellendi.');
        } catch (\Exception $e) {
            return redirect()->route('appointments')->with('error', 'Randevu durumu güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function sil($id)
    {
        $randevu = Randevu::findOrFail($id);

        // Randevuya ait paketi değişkene kaydet (varsa)
        $paket_id = $randevu->paket_id;

        // Randevuya ait rezervasyonu bul
        $rezervasyonlar = $randevu->Rezervasyonlar;

        foreach ($rezervasyonlar as $rezervasyon) {
            // Önce rezervasyona bağlı ödemeleri sil
            Odemeler::where('rezervasyon_id', $rezervasyon->id)->delete();

            // Sonra rezervasyonu sil
            $rezervasyon->delete();
        }

        // Mekan-Randevu ilişkilerini sil
        DB::table('mekan_randevus')->where('randevus_id', $id)->delete();

        // Randevuyu sil
        $randevu->delete();

        // Şimdi paketleri güvenli bir şekilde silebiliriz
        if ($paket_id) {
            try {
                DB::table('paketlers')->where('id', $paket_id)->delete();
            } catch (\Exception $e) {
                // Paket silinirken hata olursa sadece loglama yapıyoruz, işlemi durdurmuyoruz
                \Log::error('Paket silinirken hata: ' . $e->getMessage());
            }
        }

        return redirect()->route('appointments')->with('success', 'Randevu ve ilişkili tüm kayıtlar başarıyla silindi.');
    }

    public function topluSil(Request $request)
    {
        if ($request->has('secili_randevular')) {
            foreach ($request->secili_randevular as $randevuId) {
                $randevu = Randevu::find($randevuId);

                if ($randevu) {
                    // Randevuya ait paketi değişkene kaydet (varsa)
                    $paket_id = $randevu->paket_id;

                    // Randevuya ait rezervasyonları bul
                    $rezervasyonlar = $randevu->Rezervasyonlar;

                    foreach ($rezervasyonlar as $rezervasyon) {
                        // Önce rezervasyona bağlı ödemeleri sil
                        Odemeler::where('rezervasyon_id', $rezervasyon->id)->delete();

                        // Sonra rezervasyonu sil
                        $rezervasyon->delete();
                    }

                    // Mekan-Randevu ilişkilerini sil
                    DB::table('mekan_randevus')->where('randevus_id', $randevuId)->delete();

                    // Randevuyu sil
                    $randevu->delete();

                    // Şimdi paketleri güvenli bir şekilde silebiliriz
                    if ($paket_id) {
                        try {
                            DB::table('paketlers')->where('id', $paket_id)->delete();
                        } catch (\Exception $e) {
                            // Paket silinirken hata olursa sadece loglama yapıyoruz, işlemi durdurmuyoruz
                            \Log::error('Paket silinirken hata: ' . $e->getMessage());
                        }
                    }
                }
            }

            return redirect()->route('appointments')->with('success', 'Seçili randevular ve ilişkili tüm kayıtlar başarıyla silindi.');
        }

        return redirect()->route('appointments')->with('error', 'Hiçbir randevu seçilmedi.');
    }
}
