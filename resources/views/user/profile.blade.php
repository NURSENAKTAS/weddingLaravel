@extends('user.layout')

@section('title', 'Profil Bilgilerim - Kullanıcı Paneli')

@section('page-title', 'Profil Bilgilerim')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Profil Bilgileri -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-user me-2"></i>Kullanıcı Bilgileri</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=128" 
                             class="rounded-circle img-thumbnail" alt="{{ $user->name }}">
                    </div>
                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->role }}</p>
                    <hr>
                    <div class="text-start">
                        <div class="mb-3">
                            <strong><i class="fas fa-envelope me-2 text-primary"></i>E-posta:</strong>
                            <p class="ms-4">{{ $user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <strong><i class="fas fa-phone me-2 text-primary"></i>Telefon:</strong>
                            <p class="ms-4">{{ $user->phone }}</p>
                        </div>
                        <div>
                            <strong><i class="fas fa-clock me-2 text-primary"></i>Üyelik Tarihi:</strong>
                            <p class="ms-4">{{ $user->created_at->format('d.m.Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profil İstatistikleri -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-chart-pie me-2"></i>Profil İstatistikleri</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Toplam Randevu</span>
                            <span class="text-primary">{{ $user->randevular->count() }}</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="{{ $user->randevular->count() }}" aria-valuemin="0" aria-valuemax="{{ $user->randevular->count() }}"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Onaylanan Randevular</span>
                            <span class="text-success">
                                {{ $user->randevular->filter(function($randevu) {
                                    return $randevu->Rezervasyonlar->count() > 0 && $randevu->Rezervasyonlar->first()->rezervasyon_durum == 'Onaylandı';
                                })->count() }}
                            </span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                style="width: {{ $user->randevular->count() > 0 ? ($user->randevular->filter(function($randevu) {
                                    return $randevu->Rezervasyonlar->count() > 0 && $randevu->Rezervasyonlar->first()->rezervasyon_durum == 'Onaylandı';
                                })->count() / $user->randevular->count()) * 100 : 0 }}%;" 
                                aria-valuenow="{{ $user->randevular->filter(function($randevu) {
                                    return $randevu->Rezervasyonlar->count() > 0 && $randevu->Rezervasyonlar->first()->rezervasyon_durum == 'Onaylandı';
                                })->count() }}" 
                                aria-valuemin="0" 
                                aria-valuemax="{{ $user->randevular->count() }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Bekleyen Randevular</span>
                            <span class="text-warning">
                                {{ $user->randevular->filter(function($randevu) {
                                    return $randevu->Rezervasyonlar->count() > 0 && $randevu->Rezervasyonlar->first()->rezervasyon_durum == 'Beklemede';
                                })->count() }}
                            </span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-warning" role="progressbar" 
                                style="width: {{ $user->randevular->count() > 0 ? ($user->randevular->filter(function($randevu) {
                                    return $randevu->Rezervasyonlar->count() > 0 && $randevu->Rezervasyonlar->first()->rezervasyon_durum == 'Beklemede';
                                })->count() / $user->randevular->count()) * 100 : 0 }}%;" 
                                aria-valuenow="{{ $user->randevular->filter(function($randevu) {
                                    return $randevu->Rezervasyonlar->count() > 0 && $randevu->Rezervasyonlar->first()->rezervasyon_durum == 'Beklemede';
                                })->count() }}" 
                                aria-valuemin="0" 
                                aria-valuemax="{{ $user->randevular->count() }}">
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>İptal Edilen / Reddedilen</span>
                            <span class="text-danger">
                                {{ $user->randevular->filter(function($randevu) {
                                    return $randevu->Rezervasyonlar->count() > 0 && in_array($randevu->Rezervasyonlar->first()->rezervasyon_durum, ['İptal Edildi', 'Başarısız']);
                                })->count() }}
                            </span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-danger" role="progressbar" 
                                style="width: {{ $user->randevular->count() > 0 ? ($user->randevular->filter(function($randevu) {
                                    return $randevu->Rezervasyonlar->count() > 0 && in_array($randevu->Rezervasyonlar->first()->rezervasyon_durum, ['İptal Edildi', 'Başarısız']);
                                })->count() / $user->randevular->count()) * 100 : 0 }}%;" 
                                aria-valuenow="{{ $user->randevular->filter(function($randevu) {
                                    return $randevu->Rezervasyonlar->count() > 0 && in_array($randevu->Rezervasyonlar->first()->rezervasyon_durum, ['İptal Edildi', 'Başarısız']);
                                })->count() }}" 
                                aria-valuemin="0" 
                                aria-valuemax="{{ $user->randevular->count() }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Profil Düzenleme Formu -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-user-edit me-2"></i>Profil Bilgilerimi Düzenle</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Ad Soyad</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-posta Adresi</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Telefon Numarası</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <h6 class="mb-3">Şifre Değiştir (opsiyonel)</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="current_password" class="form-label">Mevcut Şifre</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="new_password" class="form-label">Yeni Şifre</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="new_password_confirmation" class="form-label">Yeni Şifre (Tekrar)</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Bilgilerimi Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Randevu Geçmişi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-history me-2"></i>Son Randevularım</h6>
                    <a href="{{ route('user.appointments') }}" class="btn btn-sm btn-primary">Tümünü Gör</a>
                </div>
                <div class="card-body">
                    @if($user->randevular->count() > 0)
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
                                    @foreach($user->randevular->sortByDesc('randevu_tarihi')->take(5) as $randevu)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($randevu->randevu_tarihi)->format('d.m.Y H:i') }}</td>
                                        <td>{{ ucfirst($randevu->randevu_türü) }}</td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <a href="{{ route('user.appointment.details', $randevu->id) }}" class="btn btn-sm btn-info">
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
                            <i class="fas fa-calendar-day fa-3x text-secondary mb-3"></i>
                            <p>Henüz bir randevunuz bulunmamaktadır.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 