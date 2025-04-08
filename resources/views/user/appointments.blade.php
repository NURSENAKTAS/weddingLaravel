@extends('user.layout')

@section('title', 'Randevularım - Kullanıcı Paneli')

@section('page-title', 'Randevularım')

<!-- Global JavaScript Fonksiyonları -->
<script type="text/javascript">
    // Filtreleme fonksiyonu
    function filtrelemeYapButon() {
        console.log('Filtreleme butonu tıklandı');
        
        var durumFiltre = document.getElementById('durum-filtre');
        var tarihBaslangicFiltre = document.getElementById('tarih-baslangic-filtre');
        var tarihBitisFiltre = document.getElementById('tarih-bitis-filtre');
        var turFiltre = document.getElementById('tur-filtre');
        var randevuCards = document.querySelectorAll('.randevu-card');
        var noResults = document.getElementById('no-results');
        
        if (!durumFiltre || !randevuCards) {
            console.error('Gerekli elementler bulunamadı');
            return false;
        }
        
        const durum = durumFiltre.value;
        const baslangicTarih = tarihBaslangicFiltre.value;
        const bitisTarih = tarihBitisFiltre.value;
        const tur = turFiltre.value;
        
        console.log('Filtre değerleri:', {durum, baslangicTarih, bitisTarih, tur});
        
        let visibleCount = 0;
        
        randevuCards.forEach(card => {
            const cardDurum = card.dataset.durum;
            const cardTarih = card.dataset.tarih;
            const cardTur = card.dataset.tur;
            
            let isVisible = true;
            
            if (durum && durum !== '' && cardDurum !== durum) {
                isVisible = false;
            }
            
            if (baslangicTarih && baslangicTarih !== '' && cardTarih < baslangicTarih) {
                isVisible = false;
            }
            
            if (bitisTarih && bitisTarih !== '' && cardTarih > bitisTarih) {
                isVisible = false;
            }
            
            if (tur && tur !== '' && cardTur !== tur) {
                isVisible = false;
            }
            
            if (isVisible) {
                card.classList.remove('d-none');
                visibleCount++;
            } else {
                card.classList.add('d-none');
            }
        });
        
        if (noResults) {
            if (visibleCount === 0) {
                noResults.classList.remove('d-none');
            } else {
                noResults.classList.add('d-none');
            }
        }
        
        console.log('Görünen kart sayısı:', visibleCount);
        return false;
    }
    
    // Sıfırlama fonksiyonu
    function sifirlaButon() {
        console.log('Sıfırla butonu tıklandı');
        
        var durumFiltre = document.getElementById('durum-filtre');
        var tarihBaslangicFiltre = document.getElementById('tarih-baslangic-filtre');
        var tarihBitisFiltre = document.getElementById('tarih-bitis-filtre');
        var turFiltre = document.getElementById('tur-filtre');
        var randevuCards = document.querySelectorAll('.randevu-card');
        var noResults = document.getElementById('no-results');
        
        if (!durumFiltre || !randevuCards) {
            console.error('Gerekli elementler bulunamadı');
            return false;
        }
        
        durumFiltre.value = '';
        tarihBaslangicFiltre.value = '';
        tarihBitisFiltre.value = '';
        turFiltre.value = '';
        
        randevuCards.forEach(card => {
            card.classList.remove('d-none');
        });
        
        if (noResults) {
            noResults.classList.add('d-none');
        }
        
        console.log('Filtreler sıfırlandı');
        return false;
    }
    
    // DOM yüklendiğinde event listener ekle
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM yüklendi, butonlara listener ekleniyor');
        
        // Butonlara event listener ekle
        var filtreBtn = document.getElementById('filtrele-btn');
        var sifirlaBtn = document.getElementById('sifirla-btn');
        
        if (filtreBtn) {
            filtreBtn.addEventListener('click', filtrelemeYapButon);
        }
        
        if (sifirlaBtn) {
            sifirlaBtn.addEventListener('click', sifirlaButon);
        }
    });
</script>

@section('styles')
<style>
    .appointment-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }

    .appointment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .appointment-status {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.5em 0.75em;
    }


    
    .icon-wrapper {
        width: 25px;
        text-align: center;
    }
    
    .card-body {
        padding-bottom: 0;
    }
    
    .card-title {
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 10px;
    }
    
    .btn-primary {
        border-radius: 5px;
        transition: all 0.2s;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .filters {
        background-color: #f8f9fc;
        border-radius: 0.5rem;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">Randevularım</h1>
            <p class="mb-4">Tüm randevularınızı görüntüleyin ve yönetin.</p>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="card mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-filter me-2"></i>Filtreleme Seçenekleri</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="durum-filtre">Durum</label>
                    <select class="form-select" id="durum-filtre">
                        <option value="">Tümü</option>
                        @foreach($statusOptions as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="tarih-baslangic-filtre">Başlangıç Tarihi</label>
                    <input type="date" class="form-control" id="tarih-baslangic-filtre">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="tarih-bitis-filtre">Bitiş Tarihi</label>
                    <input type="date" class="form-control" id="tarih-bitis-filtre">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="tur-filtre">Organizasyon Türü</label>
                    <select class="form-select" id="tur-filtre">
                        <option value="">Tümü</option>
                        @foreach($organizasyonTurleri as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="text-end mt-2">
                <button type="button" class="btn btn-secondary me-2" id="sifirla-btn">Sıfırla</button>
                <button type="button" class="btn btn-primary" id="filtrele-btn">Filtrele</button>
            </div>
        </div>
    </div>

    <!-- Randevular -->
    <div class="row" id="randevular-container">
        @foreach($randevular as $randevu)
            <div class="col-lg-4 col-md-6 mb-4 randevu-card" 
                 data-durum="{{ $randevu->Rezervasyonlar->count() > 0 ? $randevu->Rezervasyonlar->first()->rezervasyon_durum : 'Belirsiz' }}"
                 data-tarih="{{ \Carbon\Carbon::parse($randevu->randevu_tarihi)->format('Y-m-d') }}"
                 data-tur="{{ $randevu->randevu_türü }}">
                <div class="shadow px-5 py-5">
                    <!-- Organizasyon türüne göre resim -->
                    @php
                        $image = 'assets/img/parti/default.jpg';
                        if($randevu->randevu_türü == 'doğum günü partileri') $image = 'assets/img/parti/birtday.jpg';
                        elseif($randevu->randevu_türü == 'düğün organizasyonları') $image = 'assets/img/parti/Wedding Lights.jpg';
                        elseif($randevu->randevu_türü == 'nişan törenleri') $image = 'assets/img/parti/nisan.jpg';
                        elseif($randevu->randevu_türü == 'özel partiler') $image = 'assets/img/parti/ozelpartiler.jpg';
                    @endphp
                    <!-- Basit resim konteyner -->
                    <div class="card-img-container pb-3">
                        <img src="{{ asset($image) }}" class="img-fluid w-100 h-50"  alt="{{ $randevu->randevu_türü }}">
                    </div>

                    <!-- Durum Rozeti -->
                    <div class="appointment-status pb-3">
                        @if($randevu->Rezervasyonlar->count() > 0)
                            @php
                                $durum = $randevu->Rezervasyonlar->first()->rezervasyon_durum;
                                $badgeClass = 'bg-secondary';
                                if($durum == 'Onaylandı') $badgeClass = 'bg-success';
                                elseif($durum == 'Beklemede') $badgeClass = 'bg-warning';
                                elseif($durum == 'İptal Edildi') $badgeClass = 'bg-info';
                                elseif($durum == 'Başarısız') $badgeClass = 'bg-danger';
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $durum }}</span>
                        @else
                            <span class="badge bg-secondary">Belirsiz</span>
                        @endif
                    </div>

                    <div class="card-body">
                        <h5 class="card-title mb-3 fw-bold">{{ ucfirst($randevu->randevu_türü) }}</h5>
                        <div class="d-flex align-items-center mb-2">
                            <div class="icon-wrapper me-2">
                                <i class="fas fa-calendar-alt text-primary"></i>
                            </div>
                            <div>
                                {{ \Carbon\Carbon::parse($randevu->randevu_tarihi)->format('d.m.Y') }}
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="icon-wrapper me-2">
                                <i class="fas fa-clock text-primary"></i>
                            </div>
                            <div>
                                {{ \Carbon\Carbon::parse($randevu->randevu_tarihi)->format('H:i') }}
                            </div>
                        </div>

                        @if($randevu->Paketler)
                            <div class="d-flex align-items-center mb-2">
                                <div class="icon-wrapper me-2">
                                    <i class="fas fa-box text-primary"></i>
                                </div>
                                <div>
                                    {{ $randevu->Paketler->paket_adi }}
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon-wrapper me-2">
                                    <i class="fas fa-money-bill-wave text-primary"></i>
                                </div>
                                <div class="fw-bold">
                                    {{ number_format($randevu->Paketler->temel_fiyat + $randevu->Paketler->ekstra_fiyat, 0, ',', '.') }} TL
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <a href="{{ route('user.appointment.details', $randevu->id) }}" class="btn btn-primary w-100">
                            <i class="fas fa-eye me-2"></i>Detayları Görüntüle
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Sonuç bulunamadı mesajı -->
    <div id="no-results" class="card shadow mb-4 d-none">
        <div class="card-body text-center py-5">
            <i class="fas fa-search fa-5x text-secondary mb-4"></i>
            <h5 class="mb-3">Arama kriterlerinize uygun randevu bulunamadı.</h5>
        </div>
    </div>
</div>
@endsection
