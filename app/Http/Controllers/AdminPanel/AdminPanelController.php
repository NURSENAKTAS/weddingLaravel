<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Randevu;
use App\Models\User;
use App\Models\Rezervasyonlar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminPanelController extends Controller
{
    public function index()
    {
        // Bugünkü randevuları hesapla
        $today = Carbon::today();
        $todayAppointments = Randevu::whereDate('randevu_tarihi', $today)->count(); //Bugün için randevuların sayısını alıyoruz

        // Bu haftaki randevuları hesapla
        $startOfWeek = Carbon::now()->startOfWeek(); //Bu haftanın başlangıç tarihini alıyoruz
        $endOfWeek = Carbon::now()->endOfWeek(); //Bu haftanın bitiş tarihini alıyoruz
        $weeklyAppointments = Randevu::whereBetween('randevu_tarihi', [$startOfWeek, $endOfWeek])->count();
        //Randevu between bu iki tarih arasında kalanları da sayıyoruz

        // Toplam kullanıcı sayısı
        $totalUsers = User::count(); //Direkt User tablosundan değerleri sayıyoruz

        // Toplam hizmet türü (randevu türlerinin benzersiz sayısı)
        $totalServices = Randevu::distinct('randevu_türü')->count('randevu_türü');
        //Benzersiz olarak distinct olarak alıyoruz ve türüne göre sayıyoruz

        // Son 10 randevu
        $recentAppointments = Randevu::with(['kullanici', 'Rezervasyonlar'])
            ->orderBy('olusturulma_tarihi', 'desc')
            ->take(10)
            ->get();

        // Randevu durum sayıları
        $bekleyenRandevular = Rezervasyonlar::where('rezervasyon_durum', 'beklemede')->count();
        $onaylananRandevular = Rezervasyonlar::where('rezervasyon_durum', 'onaylandı')->count();
        $reddedilenRandevular = Rezervasyonlar::where('rezervasyon_durum', 'reddedildi')->count();
        $tamamlananRandevular = Rezervasyonlar::where('rezervasyon_durum', 'tamamlandı')->count();
        $iptalEdilenRandevular = Rezervasyonlar::where('rezervasyon_durum', 'iptal')->count();

        return view('panel.index', compact(
            'todayAppointments',
            'weeklyAppointments',
            'totalUsers',
            'totalServices',
            'recentAppointments',
            'bekleyenRandevular',
            'onaylananRandevular',
            'reddedilenRandevular',
            'tamamlananRandevular',
            'iptalEdilenRandevular'
        ));
    }
}
