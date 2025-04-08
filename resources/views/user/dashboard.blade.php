@extends('user.layout')

@section('title', 'Gösterge Paneli - Kullanıcı Paneli')

@section('page-title', 'Gösterge Paneli')

@section('page-icon')
<i class="fas fa-tachometer-alt"></i>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Tanıtım Alanı -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="mb-3">Hoş Geldiniz, {{ $user->name }}!</h4>
                            <p class="text-muted mb-0">
                                Kullanıcı panelinizden randevularınızı görüntüleyebilir, randevu iptal edebilir ve profil bilgilerinizi güncelleyebilirsiniz.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <div class="text-primary">
                                <i class="fas fa-calendar fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-9 text-end">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Toplam Randevu</div>
                            <div class="h5 font-weight-bold">{{ $totalAppointments }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <div class="text-success">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-9 text-end">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Onaylanan</div>
                            <div class="h5 font-weight-bold">{{ $confirmedAppointments }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <div class="text-warning">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-9 text-end">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Beklemede</div>
                            <div class="h5 font-weight-bold">{{ $pendingAppointments }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <div class="text-danger">
                                <i class="fas fa-times-circle fa-2x"></i>
                            </div>
                        </div>
                        <div class="col-9 text-end">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">İptal/Reddedilen</div>
                            <div class="h5 font-weight-bold">{{ $cancelledAppointments }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Yaklaşan Randevular -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-calendar-day me-2"></i>Yaklaşan Randevularım</h6>
                    <a href="{{ route('user.appointments') }}" class="btn btn-sm btn-primary">Tümünü Gör</a>
                </div>
                <div class="card-body">
                    @if(count($upcomingAppointments) > 0)
                        @foreach($upcomingAppointments as $appointment)
                        <div class="mb-3 p-3 border rounded @if($loop->first) bg-light @endif">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0 text-primary">{{ ucfirst($appointment->randevu_türü) }}</h6>
                                <div>
                                    @if($appointment->Rezervasyonlar->count() > 0)
                                        @php
                                            $durum = $appointment->Rezervasyonlar->first()->rezervasyon_durum;
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
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <small class="text-muted">Tarih:</small>
                                    <div>{{ \Carbon\Carbon::parse($appointment->randevu_tarihi)->format('d.m.Y') }}</div>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">Saat:</small>
                                    <div>{{ \Carbon\Carbon::parse($appointment->randevu_tarihi)->format('H:i') }}</div>
                                </div>
                            </div>
                            <div class="text-end">
                                <a href="{{ route('user.appointment.details', $appointment->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i>Detaylar
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-day fa-3x text-secondary mb-3"></i>
                            <p>Yaklaşan randevunuz bulunmamaktadır.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Son Etkinlikler -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-history me-2"></i>Son Randevularım</h6>
                    <a href="{{ route('user.appointments') }}" class="btn btn-sm btn-primary">Tümünü Gör</a>
                </div>
                <div class="card-body">
                    @if(count($latestAppointments) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Tür</th>
                                        <th>Durum</th>
                                        <th>İşlem</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestAppointments as $appointment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($appointment->randevu_tarihi)->format('d.m.Y') }}</td>
                                        <td>{{ ucfirst($appointment->randevu_türü) }}</td>
                                        <td>
                                            @if($appointment->Rezervasyonlar->count() > 0)
                                                @php
                                                    $durum = $appointment->Rezervasyonlar->first()->rezervasyon_durum;
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
                                        </td>
                                        <td>
                                            <a href="{{ route('user.appointment.details', $appointment->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-3x text-secondary mb-3"></i>
                            <p>Henüz bir randevunuz bulunmamaktadır.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hızlı Erişim Kartları -->
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-calendar-alt fa-3x text-success"></i>
                    </div>
                    <h5 class="text-center mb-3">Randevularımı Yönet</h5>
                    <p class="text-center text-muted">
                        Tüm randevularınızı görüntüleyin, filtreleme yapın ve randevu detaylarınızı inceleyin.
                    </p>
                    <div class="text-center">
                        <a href="{{ route('user.appointments') }}" class="btn btn-success">
                            <i class="fas fa-tasks me-2"></i>Randevuları Yönet
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-edit fa-3x text-info"></i>
                    </div>
                    <h5 class="text-center mb-3">Profil Bilgilerim</h5>
                    <p class="text-center text-muted">
                        Kişisel bilgilerinizi güncelleyin, şifrenizi değiştirin ve hesap ayarlarınızı yönetin.
                    </p>
                    <div class="text-center">
                        <a href="{{ route('user.profile') }}" class="btn btn-info">
                            <i class="fas fa-edit me-2"></i>Profili Düzenle
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card.border-left-primary {
        border-left: 0.25rem solid var(--primary-color) !important;
    }

    .card.border-left-success {
        border-left: 0.25rem solid var(--success-color) !important;
    }

    .card.border-left-warning {
        border-left: 0.25rem solid var(--warning-color) !important;
    }

    .card.border-left-danger {
        border-left: 0.25rem solid var(--danger-color) !important;
    }

    .text-xs {
        font-size: 0.7rem;
    }

    .card-header .font-weight-bold {
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>
@endpush

@endsection
