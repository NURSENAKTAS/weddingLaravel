@extends('panel.layout')

@section('title', 'Randevu Detayı - Yönetim Paneli')

@section('styles')
<style>
    .detail-card {
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .detail-header {
        background-color: #f8f9fa;
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
    }
    .detail-body {
        padding: 20px;
        background-color: #fff;
    }
    .detail-footer {
        background-color: #f8f9fa;
        padding: 15px;
        border-top: 1px solid #e9ecef;
    }
    .badge-default {
        background-color: #999;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Randevu Detayı <small>#{{ $randevu->id }}</small>
            </h1>
            <div class="mb-3">
                <a href="{{ route('appointments') }}" class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> Randevulara Dön
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default detail-card">
                <div class="panel-heading detail-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Randevu Bilgileri</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            @if($randevu->Rezervasyonlar->count() > 0)
                                <span class="badge badge-{{ $randevu->Rezervasyonlar->first()->rezervasyon_durum }}">
                                    {{ ucfirst($randevu->Rezervasyonlar->first()->rezervasyon_durum) }}
                                </span>
                            @else
                                <span class="badge badge-default">Belirsiz</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-body detail-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Randevu ID:</strong> {{ $randevu->id }}</p>
                            <p><strong>Randevu Tarihi:</strong> {{ date('d.m.Y H:i', strtotime($randevu->randevu_tarihi)) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Oluşturulma Tarihi:</strong> {{ date('d.m.Y', strtotime($randevu->olusturulma_tarihi)) }}</p>
                            <p><strong>Güncellenme Tarihi:</strong> {{ date('d.m.Y', strtotime($randevu->guncelleme_tarihi)) }}</p>
                            <p><strong>Durum:</strong>
                                @if($randevu->Rezervasyonlar->count() > 0)
                                    <span class="badge badge-{{ $randevu->Rezervasyonlar->first()->rezervasyon_durum }}">
                                        {{ ucfirst($randevu->Rezervasyonlar->first()->rezervasyon_durum) }}
                                    </span>
                                @else
                                    <span class="badge badge-default">Belirsiz</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Özel İstekler</h4>
                            <div class="well">
                                {!! nl2br(e($randevu->ozel_istekler ?: 'Özel istek belirtilmemiş.')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer detail-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success durum-guncelle"
                                    data-id="{{ $randevu->id }}"
                                    data-durum="{{ $randevu->Rezervasyonlar->count() > 0 ? $randevu->Rezervasyonlar->first()->rezervasyon_durum : 'beklemede' }}">
                                <i class="fa fa-refresh"></i> Durum Güncelle
                            </button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-danger randevu-sil"
                                    data-id="{{ $randevu->id }}">
                                <i class="fa fa-trash"></i> Randevuyu Sil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Kullanıcı Bilgileri</h4>
                </div>
                <div class="panel-body">
                    <p><strong>Ad Soyad:</strong> {{ $randevu->kullanici->name }}</p>
                    <p><strong>E-posta:</strong> {{ $randevu->kullanici->email }}</p>
                    <p><strong>Telefon:</strong> {{ $randevu->kullanici->phone }}</p>
                    <p><strong>Kullanıcı ID:</strong> {{ $randevu->kullanici_id }}</p>
                    <hr>
                    <a href="{{ route('users.goruntule', $randevu->kullanici_id) }}" class="btn btn-info btn-block">
                        <i class="fa fa-user"></i> Kullanıcı Profilini Görüntüle
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Durum Güncelleme Modal -->
<div class="modal fade" id="durum-modal" tabindex="-1" role="dialog" aria-labelledby="durum-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="durum-modal-label">Randevu Durumunu Güncelle</h4>
            </div>
            <form id="durum-form" method="POST" action="{{ route('appointments.durum', $randevu->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="durum">Durum</label>
                        <select name="durum" id="durum" class="form-control">
                            <option value="beklemede">Beklemede</option>
                            <option value="onaylandı">Onaylandı</option>
                            <option value="reddedildi">Reddedildi</option>
                            <option value="iptal">İptal Edildi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Silme Onay Modal -->
<div class="modal fade" id="sil-modal" tabindex="-1" role="dialog" aria-labelledby="sil-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="sil-modal-label">Randevu Silme Onayı</h4>
            </div>
            <div class="modal-body">
                <p>Bu randevuyu silmek istediğinizden emin misiniz?</p>
            </div>
            <div class="modal-footer">
                <form id="sil-form" method="POST" action="{{ route('appointments.sil', $randevu->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-danger">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Durum güncelleme modal
    $('.durum-guncelle').on('click', function() {
        var durum = $(this).data('durum');
        $('#durum').val(durum);
        $('#durum-modal').modal('show');
    });

    // Randevu silme modal
    $('.randevu-sil').on('click', function() {
        $('#sil-modal').modal('show');
    });
});
</script>
@endsection
