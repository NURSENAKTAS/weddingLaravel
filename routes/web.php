<?php

use App\Http\Controllers\AdminPanel\AdminKullanicilarController;
use App\Http\Controllers\AdminPanel\AdminPanelController;
use App\Http\Controllers\AdminPanel\AdminRandevuController;
use App\Http\Controllers\AdminPanel\AdminIletisimController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RandevuController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserPanelController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

// Anasayfa ve Genel Rotalar
Route::get("/", [IndexController::class, "index"])->name('anasayfa');
Route::post("/iletisim", [IndexController::class, "iletisimGonder"])->name('iletisim.gonder');
Route::get("/randevu", [RandevuController::class, "randevu"])->name('randevu');
Route::post("/randevu", [RandevuController::class, "store"])->name('randevu.store');

// Auth Routes
Route::get("/login", [LoginController::class, "index"])->name('login');
Route::post("/login", [LoginController::class, "login"]);
Route::get("/register", [RegisterController::class, "index"])->name('register');
Route::post("/register", [RegisterController::class, "register"]);
Route::post("/logout", [LoginController::class, "logout"])->name('logout');

// Kullanıcı Paneli Rotaları
Route::middleware('auth')->prefix('panel-kul')->group(function () {
    Route::get('/', [UserPanelController::class, 'index'])->name('user.dashboard');
    Route::get('/appointments', [UserPanelController::class, 'appointments'])->name('user.appointments');
    Route::get('/appointment/{id}', [UserPanelController::class, 'appointmentDetails'])->name('user.appointment.details');
    Route::post('/appointment/{id}/cancel', [UserPanelController::class, 'cancelAppointment'])->name('user.appointment.cancel');
    Route::get('/profile', [UserPanelController::class, 'profile'])->name('user.profile');
    Route::post('/profile/update', [UserPanelController::class, 'updateProfile'])->name('user.profile.update');
});

// Admin Paneli - Admin ve Yönetici rolleri için erişilebilir
Route::middleware([AdminMiddleware::class])->prefix('panel')->group(function () {
    // Dashboard
    Route::get('/', [AdminPanelController::class, "index"])->name('dashboard');

    // Randevular
    Route::get('/randevular', [AdminRandevuController::class, "index"])->name('appointments');
    Route::get('/randevular/{id}', [AdminRandevuController::class, "goruntule"])->name('appointments.goruntule');
    Route::post('/randevular/{id}/durum', [AdminRandevuController::class, "durumGuncelle"])->name('appointments.durum');
    Route::delete('/randevular/{id}', [AdminRandevuController::class, "sil"])->name('appointments.sil');
    Route::post('/randevular/toplu-sil', [AdminRandevuController::class, "topluSil"])->name('appointments.toplu-sil');

    // Kullanıcılar
    Route::get('/kullanicilar', [AdminKullanicilarController::class, "index"])->name('users');
    Route::get('/kullanicilar/{id}', [AdminKullanicilarController::class, "goruntule"])->name('users.goruntule');
    Route::post('/kullanicilar/{id}/durum', [AdminKullanicilarController::class, "durumGuncelle"])->name('users.durum');
    Route::delete('/kullanicilar/{id}', [AdminKullanicilarController::class, "sil"])->name('users.sil');
    Route::post('/kullanicilar/toplu-sil', [AdminKullanicilarController::class, "topluSil"])->name('users.toplu-sil');

    // İletişim
    Route::get('/iletisim', [AdminIletisimController::class, "index"])->name('iletisim');
    Route::get('/iletisim/{id}', [AdminIletisimController::class, "goruntule"])->name('iletisim.goruntule');
    Route::post('/iletisim/{id}/durum', [AdminIletisimController::class, "durumGuncelle"])->name('iletisim.durum');
    Route::post('/iletisim/tumunu-okundu', [AdminIletisimController::class, "tumunuOkundu"])->name('iletisim.tumunu-okundu');
    Route::delete('/iletisim/{id}', [AdminIletisimController::class, "sil"])->name('iletisim.sil');
    Route::post('/iletisim/toplu-sil', [AdminIletisimController::class, "topluSil"])->name('iletisim.toplu-sil');
});
