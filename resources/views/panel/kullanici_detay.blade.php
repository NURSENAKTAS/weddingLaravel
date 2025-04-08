@extends('panel.layout')

@section('title', 'Kullanıcı Detayı - Yönetim Paneli')

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
    .badge-admin {
        background-color: #d9534f;
    }
    .badge-yonetici {
        background-color: #5cb85c;
    }
    .badge-Kullanıcı {
        background-color: #5bc0de;
    }
    .badge-beklemede {
        background-color: #f0ad4e;
    }
    .badge-onaylandı {
        background-color: #5cb85c;
    }
    .badge-reddedildi {
        background-color: #d9534f;
    }
    .badge-tamamlandı {
        background-color: #5bc0de;
    }
    .badge-iptal {
        background-color: #777;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Kullanıcı Detayı <small>#{{ $kullanici->id }}</small>
            </h1>
            <div class="mb-3">
                <a href="{{ route('users') }}" class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> Kullanıcılara Dön
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default detail-card">
                <div class="panel-heading detail-header">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Kullanıcı Bilgileri</h4>
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge badge-{{ $kullanici->role }}">{{ ucfirst($kullanici->role) }}</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body detail-body">
                    <div class="text-center mb-3">
                        <img src="https://placehold.co/150" class="img-circle" alt="{{ $kullanici->name }}">
                        <h3>{{ $kullanici->name }}</h3>
                        <p class="text-muted">
                            <i class="fa fa-user"></i> {{ ucfirst($kullanici->role) }}
                        </p>
                    </div>
                    <hr>
                    <p><strong><i class="fa fa-envelope"></i> E-posta:</strong> {{ $kullanici->email }}</p>
                    <p><strong><i class="fa fa-phone"></i> Telefon:</strong> {{ $kullanici->phone }}</p>
                    <p><strong><i class="fa fa-clock-o"></i> Kayıt Tarihi:</strong> {{ $kullanici->created_at->format('d.m.Y') }}</p>
                    <p><strong><i class="fa fa-calendar"></i> Son Güncelleme:</strong> {{ $kullanici->updated_at->format('d.m.Y') }}</p>
                </div>
                <div class="panel-footer detail-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success rol-guncelle"
                                    data-id="{{ $kullanici->id }}"
                                    data-rol="{{ $kullanici->role }}">
                                <i class="fa fa-user-plus"></i> Rol Güncelle
                            </button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-danger kullanici-sil"
                                    data-id="{{ $kullanici->id }}">
                                <i class="fa fa-trash"></i> Kullanıcıyı Sil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-calendar"></i> Son Randevuları</h4>
                </div>
                <div class="panel-body">
                    @if(count($randevular) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Randevu Türü</th>
                                        <th>Tarih</th>
                                        <th>Durum</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($randevular as $randevu)
                                    <tr>
                                        <td>{{ $randevu->id }}</td>
                                        <td>{{ $randevu->randevu_türü }}</td>
                                        <td>{{ date('d.m.Y H:i', strtotime($randevu->randevu_tarihi)) }}</td>
                                        <td>
                                            @if($randevu->Rezervasyonlar->count() > 0)
                                                <span class="badge badge-{{ strtolower($randevu->Rezervasyonlar->first()->rezervasyon_durum) }}">
                                                    {{ $randevu->Rezervasyonlar->first()->rezervasyon_durum }}
                                                </span>
                                            @else
                                                <span class="badge badge-default">Beklemede</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('appointments.goruntule', $randevu->id) }}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-eye"></i> Detay
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{route("appointments")}}" class="btn btn-default btn-block">
                            <i class="fa fa-list"></i> Tüm Randevuları Görüntüle
                        </a>
                    @else
                        <p class="text-center">Bu kullanıcıya ait randevu bulunmamaktadır.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rol Güncelleme Modal -->
<div class="modal fade" id="rol-modal" tabindex="-1" role="dialog" aria-labelledby="rol-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="rol-modal-label">Kullanıcı Rolünü Güncelle</h4>
            </div>
            <form id="rol-form" method="POST" action="{{ route('users.durum', $kullanici->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role">Rol</label>
                        <select name="role" id="role" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="yonetici">Yönetici</option>
                            <option value="Kullanıcı">Kullanıcı</option>
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
                <h4 class="modal-title" id="sil-modal-label">Kullanıcı Silme Onayı</h4>
            </div>
            <div class="modal-body">
                <p>Bu kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!</p>
                <p class="text-danger"><strong>Uyarı:</strong> Kullanıcıya ait tüm randevular ve mesajlar da silinecektir.</p>
            </div>
            <div class="modal-footer">
                <form id="sil-form" method="POST" action="{{ route('users.sil', $kullanici->id) }}">
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
    // Rol güncelleme modal
    $('.rol-guncelle').on('click', function() {
        var rol = $(this).data('rol');
        $('#role').val(rol);
        $('#rol-modal').modal('show');
    });

    // Kullanıcı silme modal
    $('.kullanici-sil').on('click', function() {
        $('#sil-modal').modal('show');
    });
});
</script>
@endsection
