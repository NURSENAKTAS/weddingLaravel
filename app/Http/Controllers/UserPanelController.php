<?php

namespace App\Http\Controllers;

use App\Models\Randevu;
use App\Models\User;
use App\Models\Rezervasyonlar;
use App\Models\Paketler;
use App\Models\Organizasyonlar;
use App\Models\Mekanlar;
use App\Models\Suslemeler;
use App\Models\Menu_ogeleri;
use App\Models\Pastalar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserPanelController extends Controller
{
    /**
     * Kullanıcı ana sayfası.
     */
    public function index()
    {
        $user = Auth::user();

        // Son 5 randevu
        $latestAppointments = Randevu::where('kullanici_id', $user->id)
            ->with('Rezervasyonlar', 'Paketler')
            ->orderBy('randevu_tarihi', 'desc')
            ->take(5)
            ->get();

        // Gelecek randevular
        $upcomingAppointments = Randevu::where('kullanici_id', $user->id)
            ->where('randevu_tarihi', '>=', Carbon::now())
            ->with('Rezervasyonlar', 'Paketler')
            ->orderBy('randevu_tarihi', 'asc')
            ->take(3)
            ->get();

        // İstatistikler
        $totalAppointments = Randevu::where('id', $user->id)->count();

        $confirmedAppointments = Randevu::where('kullanici_id', $user->id)
            ->whereHas('Rezervasyonlar', function($query) {
                $query->where('rezervasyon_durum', 'Onaylandı');
            })
            ->count();

        $pendingAppointments = Randevu::where('kullanici_id', $user->id)
            ->whereHas('Rezervasyonlar', function($query) {
                $query->where('rezervasyon_durum', 'Beklemede');
            })
            ->count();

        $cancelledAppointments = Randevu::where('kullanici_id', $user->id)
            ->whereHas('Rezervasyonlar', function($query) {
                $query->whereIn('rezervasyon_durum', ['İptal Edildi', 'Başarısız']);
            })
            ->count();

        return view('user.dashboard', compact(
            'user',
            'latestAppointments',
            'upcomingAppointments',
            'totalAppointments',
            'confirmedAppointments',
            'pendingAppointments',
            'cancelledAppointments'
        ));
    }

    /**
     * Kullanıcının randevularını listeler.
     */
    public function appointments(Request $request)
    {
        $user = Auth::user();

        // Tüm randevuları bir defada çekelim
        $randevular = Randevu::where('kullanici_id', $user->id)
            ->with(['Rezervasyonlar', 'Paketler'])
            ->orderBy('randevu_tarihi', 'desc')
            ->get();

        // Durum seçenekleri
        $statusOptions = [
            'Onaylandı' => 'Onaylandı',
            'Beklemede' => 'Beklemede',
            'İptal Edildi' => 'İptal Edildi',
            'Başarısız' => 'Reddedildi'
        ];

        // Organizasyon türleri
        $organizasyonTurleri = [
            'düğün organizasyonları' => 'Düğün Organizasyonları',
            'doğum günü partileri' => 'Doğum Günü Partileri',
            'nişan törenleri' => 'Nişan Törenleri',
            'özel partiler' => 'Özel Partiler'
        ];

        return view('user.appointments', compact('randevular', 'statusOptions', 'organizasyonTurleri'));
    }

    /**
     * Bir randevunun detaylarını gösterir.
     */
    public function appointmentDetails($id)
    {
        $user = Auth::user();

        $randevu = Randevu::where('id', $id)
            ->where('kullanici_id', $user->id)
            ->with(['Rezervasyonlar'])
            ->firstOrFail();

        // Paket bilgilerini ve ilişkili verileri al
        $paket = Paketler::find($randevu->paket_id);
        
        $mekan = $paket ? Mekanlar::find($paket->mekan_id) : null;
        $dekorasyon = $paket ? Suslemeler::find($paket->susleme_id) : null;
        $menu = $paket ? Menu_ogeleri::find($paket->menu_ogeleri_id) : null;
        $pasta = $paket ? Pastalar::find($paket->pasta_id) : null;

        // Durum renkleri için dizi
        $statusColor = [
            'Beklemede' => 'warning',
            'Onaylandı' => 'success',
            'İptal Edildi' => 'danger',
            'Başarısız' => 'danger',
            'Tamamlandı' => 'primary'
        ];

        return view('user.appointment-details', compact(
            'randevu',
            'paket',
            'mekan',
            'dekorasyon',
            'menu',
            'pasta',
            'statusColor'
        ));
    }

    /**
     * Kullanıcı profil sayfasını gösterir.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Kullanıcı profil bilgilerini günceller.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:20',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!\Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Mevcut şifreniz doğru değil.');
            }

            $user->password = \Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
    }

    /**
     * Randevu iptali işlemi
     */
    public function cancelAppointment(Request $request, $id)
    {
        $user = Auth::user();

        // Randevuyu bul ve kullanıcıya ait olduğunu doğrula
        $randevu = Randevu::where('id', $id)
            ->where('kullanici_id', $user->id)
            ->with('Rezervasyonlar')
            ->firstOrFail();

        // Randevu sadece "Beklemede" durumundaysa iptal edilebilir
        if ($randevu->Rezervasyonlar->count() == 0 || $randevu->Rezervasyonlar->first()->rezervasyon_durum != 'Beklemede') {
            return redirect()
                ->route('user.appointment.details', $id)
                ->with('error', 'Bu randevu iptal edilemez. İptal edilebilmesi için randevunun "Beklemede" durumunda olması gerekir.');
        }

        // Rezervasyonu güncelle
        $rezervasyon = $randevu->Rezervasyonlar->first();
        $rezervasyon->rezervasyon_durum = 'İptal Edildi';
        $rezervasyon->guncelleme_tarihi = now();
        $rezervasyon->save();

        return redirect()
            ->route('user.appointment.details', $id)
            ->with('success', 'Randevunuz başarıyla iptal edildi.');
    }
}
