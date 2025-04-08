@extends('user.layout')

@section('title', 'Randevu Detayı - Kullanıcı Paneli')

@section('page-title', 'Randevu Detayı')

@section('styles')
<style>
.color-white
{
    color: white !important;
}
/* Özel stiller burada tanımlanabilir */
.container-fluid {
    width: 100% !important;
    max-width: 100% !important;
    padding-right: 15px !important;
    padding-left: 15px !important;
}

/* Kartların tam genişlikte görünmesini sağla */
.card {
    width: 100% !important;
    height: 100% !important;
}

/* Kolonların genişliklerini düzelt */
@media (min-width: 992px) {
    .col-lg-6 {
        width: 50% !important;
        max-width: 50% !important;
        flex: 0 0 50% !important;
    }
}

/* Gutter genişliğini düzelt */
.row.g-3 {
    --bs-gutter-x: 1.5rem !important;
    --bs-gutter-y: 1.5rem !important;
}

/* Footer'ın alt kısma sabitlenmesi */
html, body {
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

main.content {
    flex: 1 0 auto;
}

footer {
    flex-shrink: 0;
    width: 100%;
    margin-top: auto;
}

/* Toplam tutar kısmına sabit stil */
.price-box {
    border-radius: 0.25rem !important;
    background-color: #cff4fc !important;
    border: 1px solid #9eeaf9 !important;
    color: #055160 !important;
}

.alert-info i.fa-money-bill-wave {
    color: #055160 !important;
}

/* Modal açıldığında sayfanın kaymasını önle */
body.modal-open {
    padding-right: 0 !important;
    overflow-y: auto !important;
}
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-md-12">
            <a href="{{ route('user.appointments') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Randevularıma Dön
            </a>
        </div>
    </div>

    <div class="row g-3">
        <!-- Randevu Genel Bilgileri -->
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold color-white"><i class="fas fa-info-circle me-2"></i>Randevu Bilgileri</h6>

                    @if($randevu->Rezervasyonlar->count() > 0)
                        @php
                            $durum = $randevu->Rezervasyonlar->first()->rezervasyon_durum;
                            $badgeClass = 'bg-secondary';
                            if($durum == 'Onaylandı') $badgeClass = 'bg-success';
                            elseif($durum == 'Beklemede') $badgeClass = 'bg-warning';
                            elseif($durum == 'İptal Edildi') $badgeClass = 'bg-info';
                            elseif($durum == 'Başarısız') $badgeClass = 'bg-danger';
                        @endphp
                        <span class="badge {{ $badgeClass }} fs-6">{{ $durum }}</span>
                    @else
                        <span class="badge bg-secondary fs-6">Belirsiz</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Randevu Numarası</p>
                            <p class="fw-bold">{{ $randevu->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Oluşturulma Tarihi</p>
                            <p class="fw-bold">{{ \Carbon\Carbon::parse($randevu->olusturulma_tarihi)->format('d.m.Y') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Randevu Tarihi</p>
                            <p class="fw-bold">{{ \Carbon\Carbon::parse($randevu->randevu_tarihi)->format('d.m.Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Randevu Saati</p>
                            <p class="fw-bold">{{ \Carbon\Carbon::parse($randevu->randevu_tarihi)->format('H:i') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Organizasyon Türü</p>
                            <p class="fw-bold">{{ ucfirst($randevu->randevu_türü) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Paket Adı</p>
                            <p class="fw-bold">
                                @if($paket)
                                    {{ $paket->paket_adi }}
                                @else
                                    Belirtilmemiş
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p class="mb-1 text-muted small">Özel İstekler</p>
                            <p class="fw-bold">
                                @if($randevu->ozel_istekler)
                                    {{ $randevu->ozel_istekler }}
                                @else
                                    Belirtilmemiş
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($randevu->Rezervasyonlar->count() > 0 && $randevu->Rezervasyonlar->first()->rezervasyon_durum == 'Beklemede')
                    <div class="mt-4">
                        <button type="button" id="cancelAppointmentBtn" class="btn btn-danger me-2">
                            <i class="fas fa-times-circle me-2"></i>Randevuyu İptal Et
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Paket Detayları -->
        <div class="col-lg-6">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-primary text-white">
                    <h7 class="m-0 font-weight-bold color-white"><i class="fas fa-box-open me-2"></i>Paket Detayları</h7>
                </div>
                <div class="card-body">
                    @if($paket)
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">Mekan</p>
                                <p class="fw-bold">
                                    @if($mekan)
                                        {{ $mekan->mekan_adi }}
                                    @else
                                        Belirtilmemiş
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">Süsleme</p>
                                <p class="fw-bold">
                                    @if($dekorasyon)
                                        {{ $dekorasyon->susleme_adi }}
                                    @else
                                        Belirtilmemiş
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">Menü</p>
                                <p class="fw-bold">
                                    @if($menu)
                                        {{ $menu->menu_adi }}
                                    @else
                                        Belirtilmemiş
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1 text-muted small">Pasta</p>
                                <p class="fw-bold">
                                    @if($pasta)
                                        {{ $pasta->pasta_adi }}
                                    @else
                                        Belirtilmemiş
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($mekan)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <p class="mb-1 text-muted small">Mekan Konumu</p>
                                <p class="fw-bold">{{ $mekan->konum }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="price-box p-3 mb-0 mt-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-money-bill-wave fa-2x"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Toplam Tutar</h6>
                                    <h4 class="mb-0">
                                        {{ number_format(($paket->temel_fiyat + $paket->ekstra_fiyat), 2, ',', '.') }} ₺
                                    </h4>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-secondary mb-3"></i>
                            <p>Bu randevu için paket bilgisi bulunmamaktadır.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Detaylı Paket Bilgileri -->
    @if($paket)
    <div class="row g-3 mt-3">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3 bg-primary text-white">
                    <h7 class="m-0 font-weight-bold"><i class="fas fa-box-open me-2"></i>Detaylı Paket Bilgileri</h7>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Mekan Bilgisi -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light border-0">
                                    <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Mekan</h6>
                                </div>
                                <div class="card-body">
                                    @if($mekan)
                                        <div class="d-flex mb-3">
                                            @if($mekan->resim_url)
                                                <img src="{{ asset('assets/img/mekan/' . $mekan->resim_url) }}" alt="{{ $mekan->mekan_adi }}" class="me-3 rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="me-3 rounded bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                    <i class="fas fa-building fa-2x text-secondary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $mekan->mekan_adi }}</h6>
                                                <p class="mb-1 text-muted"><i class="fas fa-map-pin me-1"></i> {{ $mekan->konum }}</p>
                                                <p class="mb-0 text-muted"><i class="fas fa-money-bill-wave me-1"></i> {{ number_format($mekan->fiyat, 2, ',', '.') }} ₺</p>
                                            </div>
                                        </div>
                                        <p class="mb-0"><strong>Açıklama:</strong> {{ Str::limit($mekan->aciklama, 150) }}</p>
                                    @else
                                        <p class="text-muted mb-0">Mekan bilgisi bulunamadı.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Süsleme Bilgisi -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light border-0">
                                    <h6 class="mb-0"><i class="fas fa-gift me-2 text-primary"></i>Süsleme</h6>
                                </div>
                                <div class="card-body">
                                    @if($dekorasyon)
                                        <div class="d-flex mb-3">
                                            @if($dekorasyon->resim_url)
                                                <img src="{{ asset('assets/img/suslemeler/' . $dekorasyon->resim_url) }}" alt="{{ $dekorasyon->susleme_adi }}" class="me-3 rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="me-3 rounded bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                    <i class="fas fa-birthday-cake fa-2x text-secondary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $dekorasyon->susleme_adi }}</h6>
                                                <p class="mb-0 text-muted"><i class="fas fa-palette me-1"></i> {{ $dekorasyon->aciklama }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">Süsleme bilgisi bulunamadı.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Menü Bilgisi -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light border-0">
                                    <h6 class="mb-0"><i class="fas fa-utensils me-2 text-primary"></i>İkram Menüsü</h6>
                                </div>
                                <div class="card-body">
                                    @if($menu)
                                        <div class="d-flex mb-3">
                                            @if($menu->resim_url)
                                                <img src="{{ asset('assets/img/yemekler/' . $menu->resim_url) }}" alt="{{ $menu->menu_adi }}" class="me-3 rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="me-3 rounded bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                    <i class="fas fa-hamburger fa-2x text-secondary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $menu->menu_adi }}</h6>
                                                <p class="mb-0 text-muted"><i class="fas fa-info-circle me-1"></i> {{ $menu->aciklama }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">Menü bilgisi bulunamadı.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Pasta Bilgisi -->
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header bg-light border-0">
                                    <h6 class="mb-0"><i class="fas fa-birthday-cake me-2 text-primary"></i>Pasta</h6>
                                </div>
                                <div class="card-body">
                                    @if($pasta)
                                        <div class="d-flex mb-3">
                                            @if($pasta->resim_url)
                                                <img src="{{ asset('assets/img/pastalar/' . $pasta->resim_url) }}" alt="{{ $pasta->pasta_adi }}" class="me-3 rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                            @else
                                                <div class="me-3 rounded bg-light d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                    <i class="fas fa-birthday-cake fa-2x text-secondary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-1">{{ $pasta->pasta_adi }}</h6>
                                                <p class="mb-0 text-muted"><i class="fas fa-info-circle me-1"></i> {{ $pasta->aciklama }}</p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">Pasta bilgisi bulunamadı.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- İptal Etme Modalı -->
@if($randevu->Rezervasyonlar->count() > 0 && $randevu->Rezervasyonlar->first()->rezervasyon_durum == 'Beklemede')
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="cancelModalLabel">Randevu İptal Onayı</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
            </div>
            <form id="cancelAppointmentForm" action="{{ route('user.appointment.cancel', $randevu->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="mb-3">Randevunuzu iptal etmek istediğinize emin misiniz?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Bu işlem geri alınamaz.
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                    <button type="submit" id="confirmCancelBtn" class="btn btn-danger">
                        <i class="fas fa-times-circle me-2"></i>İptal Et
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
// Sayfa yüklendiğinde
document.addEventListener('DOMContentLoaded', function() {
    // İptal modalını aç
    const cancelBtn = document.getElementById('cancelAppointmentBtn');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('cancelModal'));
            modal.show();
        });
    }

    // İptal formunu gönder
    const cancelForm = document.getElementById('cancelAppointmentForm');
    if (cancelForm) {
        cancelForm.addEventListener('submit', function() {
            // Form gönderilirken butonun durumunu değiştir
            const confirmBtn = document.getElementById('confirmCancelBtn');
            if (confirmBtn) {
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> İşleniyor...';
            }
        });
    }
});
</script>
@endsection
