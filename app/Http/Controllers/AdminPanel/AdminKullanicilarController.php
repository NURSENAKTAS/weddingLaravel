<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Iletisim;
use App\Models\Randevu;
use App\Models\Rezervasyonlar;
use App\Models\Odemeler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AdminKullanicilarController extends Controller
{
    public function index()
    {
        // Tüm kullanıcıları çek, en yeniler üstte olacak şekilde
        $kullanicilar = User::orderBy('created_at', 'desc')->get();
        return view("panel.users", compact('kullanicilar'));
    }

    public function goruntule($id)
    {
        $kullanici = User::findOrFail($id);
        $randevular = $kullanici->randevular()->orderBy('olusturulma_tarihi', 'desc')->take(10)->get();
        return view('panel.kullanici_detay', compact('kullanici', 'randevular'));
    }

    public function durumGuncelle(Request $request, $id)
    {
        $kullanici = User::findOrFail($id);
        $kullanici->role = $request->role;
        $kullanici->save();

        return redirect()->route('users')->with('success', 'Kullanıcı rolü başarıyla güncellendi.');
    }

    public function sil($id)
    {
        try {
            // İlgili kullanıcıyı bul
            $kullanici = User::findOrFail($id);

            // İlişkili iletişim bilgilerini güncelle (kullanıcı bağlantısını kaldır)
            $kullanici->iletisimler()->update(['kullanici_id' => null]);

            // Kullanıcıya ait randevuları bul
            $randevular = $kullanici->randevular;

            // Her randevu için ilişkili kayıtları sil
            foreach ($randevular as $randevu) {
                // Rezervasyonları bul
                $rezervasyonlar = $randevu->Rezervasyonlar;

                // Her rezervasyon için ödemeleri sil
                foreach ($rezervasyonlar as $rezervasyon) {
                    Odemeler::where('rezervasyon_id', $rezervasyon->id)->delete();
                    $rezervasyon->delete();
                }

                // Mekan-Randevu ilişkilerini sil
                if (Schema::hasTable('mekan_randevus')) {
                    DB::table('mekan_randevus')->where('randevus_id', $randevu->id)->delete();
                }

                // Randevuyu sil
                $randevu->delete();
            }

            // Kullanıcıyı sil
            $kullanici->delete();

            return redirect()->route('users')->with('success', 'Kullanıcı ve ilişkili tüm kayıtlar başarıyla silindi.');
        } catch (\Exception $e) {
            return redirect()->route('users')->with('error', 'Kullanıcı silinirken hata oluştu: ' . $e->getMessage());
        }
    }

    public function topluSil(Request $request)
    {
        if (!$request->has('secili_kullanicilar')) {
            return redirect()->route('users')->with('error', 'Hiçbir kullanıcı seçilmedi.');
        }

        try {
            // Seçilen kullanıcıların her biri için silme işlemi yap
            foreach ($request->secili_kullanicilar as $userId) {
                $kullanici = User::find($userId);

                if (!$kullanici) {
                    continue;
                }

                // İlişkili iletişim bilgilerini güncelle (kullanıcı bağlantısını kaldır)
                $kullanici->iletisimler()->update(['kullanici_id' => null]);

                // Kullanıcıya ait randevuları bul
                $randevular = $kullanici->randevular;

                // Her randevu için ilişkili kayıtları sil
                foreach ($randevular as $randevu) {
                    // Rezervasyonları bul
                    $rezervasyonlar = $randevu->Rezervasyonlar;

                    // Her rezervasyon için ödemeleri sil
                    foreach ($rezervasyonlar as $rezervasyon) {
                        Odemeler::where('rezervasyon_id', $rezervasyon->id)->delete();
                        $rezervasyon->delete();
                    }

                    // Mekan-Randevu ilişkilerini sil
                    if (Schema::hasTable('mekan_randevus')) {
                        DB::table('mekan_randevus')->where('randevus_id', $randevu->id)->delete();
                    }

                    // Randevuyu sil
                    $randevu->delete();
                }

                // Kullanıcıyı sil
                $kullanici->delete();
            }

            return redirect()->route('users')->with('success', 'Seçili kullanıcılar ve ilişkili tüm kayıtlar başarıyla silindi.');
        } catch (\Exception $e) {
            return redirect()->route('users')->with('error', 'Kullanıcılar silinirken hata oluştu: ' . $e->getMessage());
        }
    }
}
