<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Iletisim;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminIletisimController extends Controller
{
    public function index()
    {
        // Tüm iletişim mesajlarını çek, en yeniler üstte olacak şekilde
        $mesajlar = Iletisim::with('kullanici')->orderBy('olusturulma_tarihi', 'desc')->get();
        return view("panel.iletisim", compact('mesajlar'));
    }

    public function goruntule($id)
    {
        // İlgili mesajı ve kullanıcı bilgilerini çek
        $mesaj = Iletisim::with('kullanici')->findOrFail($id);
        
        // Önceki ve sonraki mesajların ID'lerini al
        $oncekiMesaj = Iletisim::where('id', '<', $id)->orderBy('id', 'desc')->first();
        $sonrakiMesaj = Iletisim::where('id', '>', $id)->orderBy('id', 'asc')->first();
        
        return view('panel.iletisim_detay', compact('mesaj', 'oncekiMesaj', 'sonrakiMesaj'));
    }

    public function durumGuncelle(Request $request, $id)
    {
        try {
            // Veri doğrulama
            $validated = $request->validate([
                'durum' => 'required|in:beklemede,yanıtlandı,kapatıldı',
            ]);
            
            // İlgili mesajı bul
            $mesaj = Iletisim::findOrFail($id);
            
            // Eski durumu kaydet
            $eskiDurum = $mesaj->durum;
            
            // Durumu güncelle
            $mesaj->durum = $request->durum;
            $mesaj->save();
            
            // Log kaydı
            // activity()->performedOn($mesaj)->log('İletişim mesajı durumu değiştirildi: ' . $eskiDurum . ' -> ' . $request->durum);
            
            // Kullanıcının geldiği sayfaya göre yönlendirme yap
            $referer = $request->headers->get('referer');
            if (strpos($referer, 'iletisim/' . $id) !== false) {
                // Detay sayfasından geldiyse, detay sayfasına geri gönder
                return redirect()->route('iletisim.goruntule', $id)->with('success', 'Mesaj durumu başarıyla güncellendi.');
            } else {
                // Listeden geldiyse, listeye geri gönder
                return redirect()->route('iletisim')->with('success', 'Mesaj durumu başarıyla güncellendi.');
            }
        } catch (\Exception $e) {
            $referer = $request->headers->get('referer');
            if (strpos($referer, 'iletisim/' . $id) !== false) {
                return redirect()->route('iletisim.goruntule', $id)->with('error', 'Mesaj durumu güncellenirken hata oluştu: ' . $e->getMessage());
            } else {
                return redirect()->route('iletisim')->with('error', 'Mesaj durumu güncellenirken hata oluştu: ' . $e->getMessage());
            }
        }
    }

    public function sil($id)
    {
        try {
            // İlgili mesajı bul
            $mesaj = Iletisim::findOrFail($id);
            
            // Silme işlemini gerçekleştir
            $mesaj->delete();
            
            return redirect()->route('iletisim')->with('success', 'Mesaj başarıyla silindi.');
        } catch (\Exception $e) {
            return redirect()->route('iletisim')->with('error', 'Mesaj silinirken hata oluştu: ' . $e->getMessage());
        }
    }

    public function topluSil(Request $request)
    {
        if (!$request->has('secili_mesajlar')) {
            return redirect()->route('iletisim')->with('error', 'Hiçbir mesaj seçilmedi.');
        }
        
        try {
            // Seçili mesajları tek seferde sil
            Iletisim::whereIn('id', $request->secili_mesajlar)->delete();
            
            // Silinen mesaj sayısını al
            $silinenSayi = count($request->secili_mesajlar);
            
            return redirect()->route('iletisim')->with('success', $silinenSayi . ' mesaj başarıyla silindi.');
        } catch (\Exception $e) {
            return redirect()->route('iletisim')->with('error', 'Mesajlar silinirken hata oluştu: ' . $e->getMessage());
        }
    }
    
    public function tumunuOkundu(Request $request)
    {
        try {
            // Beklemedeki tüm mesajları yanıtlandı olarak işaretle
            $etkilenenSayi = Iletisim::where('durum', 'beklemede')->update(['durum' => 'yanıtlandı']);
            
            return redirect()->route('iletisim')->with('success', $etkilenenSayi . ' mesaj okundu olarak işaretlendi.');
        } catch (\Exception $e) {
            return redirect()->route('iletisim')->with('error', 'Mesajlar işaretlenirken hata oluştu: ' . $e->getMessage());
        }
    }
}
