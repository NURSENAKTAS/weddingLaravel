@extends('panel.layout')

@section('title', 'Dashboard - Yönetim Paneli')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Dashboard <small>Yönetim Paneli Özeti</small>
        </h1>
    </div>
</div>

<!-- Dashboard Statistic -->
<div class="row">
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-primary text-center no-boder bg-color-blue">
            <div class="panel-body">
                <i class="fa fa-calendar fa-5x"></i>
                <h3>{{ $todayAppointments }}</h3>
            </div>
            <div class="panel-footer back-footer-blue">
                Bugünkü Randevular
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-primary text-center no-boder bg-color-green">
            <div class="panel-body">
                <i class="fa fa-calendar-o fa-5x"></i>
                <h3>{{ $weeklyAppointments }}</h3>
            </div>
            <div class="panel-footer back-footer-green">
                Bu Haftaki Randevular
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-primary text-center no-boder bg-color-brown">
            <div class="panel-body">
                <i class="fa fa-users fa-5x"></i>
                <h3>{{ $totalUsers }}</h3>
            </div>
            <div class="panel-footer back-footer-brown">
                Toplam Kullanıcı
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-primary text-center no-boder bg-color-red">
            <div class="panel-body">
                <i class="fa fa-list fa-5x"></i>
                <h3>{{ $totalServices }}</h3>
            </div>
            <div class="panel-footer back-footer-red">
                Toplam Hizmet
            </div>
        </div>
    </div>
</div>

<!-- Son Randevular -->
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-clock-o fa-fw"></i> Son Randevular
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kullanıcı</th>
                                <th>Randevu Türü</th>
                                <th>Tarih</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($recentAppointments) > 0)
                                @foreach($recentAppointments as $randevu)
                                <tr>
                                    <td>{{ $randevu->id }}</td>
                                    <td>{{ $randevu->kullanici->name ?? 'Anonim' }}</td>
                                    <td>{{ $randevu->randevu_türü }}</td>
                                    <td>{{ \Carbon\Carbon::parse($randevu->randevu_tarihi)->format('d.m.Y H:i') }}</td>
                                    <td>
                                        @if($randevu->Rezervasyonlar->count() > 0)
                                            <span class="badge badge-{{ $randevu->Rezervasyonlar->first()->rezervasyon_durum }}">
                                                {{ ucfirst($randevu->Rezervasyonlar->first()->rezervasyon_durum) }}
                                            </span>
                                        @else
                                            <span class="badge badge-default">Belirsiz</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('appointments.goruntule', $randevu->id) }}" class="btn btn-primary btn-xs">
                                            <i class="fa fa-eye"></i> Detay
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Henüz randevu bulunmamaktadır.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <a href="{{ route('appointments') }}" class="btn btn-default">Tüm Randevuları Görüntüle</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> Hızlı Randevu Durumları
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <div class="list-group-item">
                        <i class="fa fa-clock-o fa-fw"></i> Beklemede
                        <span class="pull-right text-muted small">
                            <em>{{ $bekleyenRandevular }}</em>
                        </span>
                    </div>
                    <div class="list-group-item">
                        <i class="fa fa-check fa-fw"></i> Onaylandı
                        <span class="pull-right text-muted small">
                            <em>{{ $onaylananRandevular }}</em>
                        </span>
                    </div>
                    <div class="list-group-item">
                        <i class="fa fa-times fa-fw"></i> Reddedildi
                        <span class="pull-right text-muted small">
                            <em>{{ $reddedilenRandevular }}</em>
                        </span>
                    </div>
                    <div class="list-group-item">
                        <i class="fa fa-check-circle fa-fw"></i> Tamamlandı
                        <span class="pull-right text-muted small">
                            <em>{{ $tamamlananRandevular }}</em>
                        </span>
                    </div>
                    <div class="list-group-item">
                        <i class="fa fa-ban fa-fw"></i> İptal Edildi
                        <span class="pull-right text-muted small">
                            <em>{{ $iptalEdilenRandevular }}</em>
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('appointments') }}" class="btn btn-default">Randevuları Yönet</a>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-users fa-fw"></i> Kullanıcı Rolleri
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <div class="list-group-item">
                        <i class="fa fa-shield fa-fw"></i> Admin
                        <span class="pull-right text-muted small">
                            <em>{{ App\Models\User::where('role', 'admin')->count() }}</em>
                        </span>
                    </div>
                    <div class="list-group-item">
                        <i class="fa fa-cog fa-fw"></i> Yönetici
                        <span class="pull-right text-muted small">
                            <em>{{ App\Models\User::where('role', 'yonetici')->count() }}</em>
                        </span>
                    </div>
                    <div class="list-group-item">
                        <i class="fa fa-user fa-fw"></i> Üye
                        <span class="pull-right text-muted small">
                            <em>{{ App\Models\User::where('role', 'Kullanıcı')->count() }}</em>
                        </span>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('users') }}" class="btn btn-default">Kullanıcıları Yönet</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
