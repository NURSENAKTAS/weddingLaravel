@extends('panel.layout')

@section('title', 'Mesaj Detayı - Yönetim Paneli')

@section('styles')
<style>
    .message-card {
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .message-header {
        background-color: #f8f9fa;
        padding: 15px;
        border-bottom: 1px solid #e9ecef;
    }
    .message-body {
        padding: 20px;
        background-color: #fff;
    }
    .message-footer {
        background-color: #f8f9fa;
        padding: 15px;
        border-top: 1px solid #e9ecef;
    }
    .nav-buttons {
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .badge-beklemede {
        background-color: #f0ad4e;
    }
    .badge-yanıtlandı {
        background-color: #5cb85c;
    }
    .badge-kapatıldı {
        background-color: #d9534f;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Mesaj Detayı <small>#{{ $mesaj->id }}</small>
            </h1>
        </div>
    </div>

    <!-- Navigasyon Butonları -->
    <div class="row">
        <div class="col-md-12 nav-buttons">
            <div>
                <a href="{{ route('iletisim') }}" class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> Mesajlara Dön
                </a>
            </div>
            <div>
                @if($oncekiMesaj)
                <a href="{{ route('iletisim.goruntule', $oncekiMesaj->id) }}" class="btn btn-default">
                    <i class="fa fa-chevron-left"></i> Önceki Mesaj
                </a>
                @else
                <button class="btn btn-default" disabled>
                    <i class="fa fa-chevron-left"></i> Önceki Mesaj
                </button>
                @endif
                
                @if($sonrakiMesaj)
                <a href="{{ route('iletisim.goruntule', $sonrakiMesaj->id) }}" class="btn btn-default">
                    Sonraki Mesaj <i class="fa fa-chevron-right"></i>
                </a>
                @else
                <button class="btn btn-default" disabled>
                    Sonraki Mesaj <i class="fa fa-chevron-right"></i>
                </button>
                @endif
            </div>
        </div>
    </div>
    

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default message-card">
                <div class="panel-heading message-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>{{ $mesaj->konu }}</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge badge-{{ $mesaj->durum }}">{{ ucfirst($mesaj->durum) }}</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body message-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Gönderen:</strong> {{ $mesaj->ad_soyad }}
                        </div>
                        <div class="col-md-6">
                            <strong>E-posta:</strong> {{ $mesaj->email }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tarih:</strong> {{ $mesaj->created_at->format('d.m.Y H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Kullanıcı ID:</strong> 
                            @if($mesaj->kullanici_id)
                                {{ $mesaj->kullanici_id }}
                            @else
                                <span class="text-muted">Ziyaretçi</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well" style="background-color: #f9f9f9; padding: 15px; border-radius: 5px;">
                                {!! nl2br(e($mesaj->mesaj)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer message-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success durum-guncelle"
                                    data-id="{{ $mesaj->id }}"
                                    data-durum="{{ $mesaj->durum }}">
                                <i class="fa fa-refresh"></i> Durum Güncelle
                            </button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-danger mesaj-sil"
                                    data-id="{{ $mesaj->id }}">
                                <i class="fa fa-trash"></i> Mesajı Sil
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
                    @if($mesaj->kullanici)
                        <p><strong>Ad Soyad:</strong> {{ $mesaj->kullanici->name }}</p>
                        <p><strong>E-posta:</strong> {{ $mesaj->kullanici->email }}</p>
                        <p><strong>Telefon:</strong> {{ $mesaj->kullanici->phone }}</p>
                        <p><strong>Kayıt Tarihi:</strong> {{ $mesaj->kullanici->created_at->format('d.m.Y') }}</p>
                        <hr>
                        <a href="{{ route('users.goruntule', $mesaj->kullanici->id) }}" class="btn btn-info btn-block">
                            <i class="fa fa-user"></i> Kullanıcı Profilini Görüntüle
                        </a>
                    @else
                        <p class="text-muted">Bu mesaj web sitesi ziyaretçisi tarafından gönderilmiş.</p>
                        <p><strong>Ad Soyad:</strong> {{ $mesaj->ad_soyad }}</p>
                        <p><strong>E-posta:</strong> {{ $mesaj->email }}</p>
                    @endif
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
                <h4 class="modal-title" id="durum-modal-label">Mesaj Durumunu Güncelle</h4>
            </div>
            <form id="durum-form" method="POST" action="{{ route('iletisim.durum', $mesaj->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="durum">Durum</label>
                        <select name="durum" id="durum" class="form-control">
                            <option value="beklemede">Beklemede</option>
                            <option value="yanıtlandı">Yanıtlandı</option>
                            <option value="kapatıldı">Kapatıldı</option>
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
                <h4 class="modal-title" id="sil-modal-label">Mesaj Silme Onayı</h4>
            </div>
            <div class="modal-body">
                <p>Bu mesajı silmek istediğinizden emin misiniz?</p>
            </div>
            <div class="modal-footer">
                <form id="sil-form" method="POST" action="{{ route('iletisim.sil', $mesaj->id) }}">
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

    // Mesaj silme modal
    $('.mesaj-sil').on('click', function() {
        $('#sil-modal').modal('show');
    });
});
</script>
@endsection
