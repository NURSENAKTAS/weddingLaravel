@extends('panel.layout')

@section('title', 'Kullanıcılar - Yönetim Paneli')

@section('styles')
<style>
    .badge-admin {
        background-color: #d9534f;
    }
    .badge-yonetici {
        background-color: #5cb85c;
    }
    .badge-kullanici {
        background-color: #5bc0de;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Kullanıcılar <small>Tüm kullanıcıları yönetin</small>
            </h1>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-filter"></i> Filtreler
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rol</label>
                                <select id="rol-filtresi" class="form-control">
                                    <option value="">Tümü</option>
                                    <option value="admin">Admin</option>
                                    <option value="yonetici">Yönetici</option>
                                    <option value="kullanici">Kullanıcı</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Kayıt Tarihi</label>
                                <input type="date" id="tarih-filtresi" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" id="filtre-temizle" class="btn btn-default form-control">Filtreleri Temizle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kullanıcılar Tablosu -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-users"></i> Kullanıcılar
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-danger btn-sm" id="toplu-sil-btn">
                                <i class="fa fa-trash"></i> Seçilenleri Sil
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <form id="kullanicilar-form" method="POST" action="{{ route('users.toplu-sil') }}">
                            @csrf
                            <table class="table table-striped table-bordered table-hover" id="kullanicilar-tablosu">
                                <thead>
                                    <tr>
                                        <th width="20">
                                            <input type="checkbox" id="tumunu-sec">
                                        </th>
                                        <th width="50">ID</th>
                                        <th>Ad Soyad</th>
                                        <th>E-posta</th>
                                        <th>Telefon</th>
                                        <th width="100">Rol</th>
                                        <th width="120">Kayıt Tarihi</th>
                                        <th width="120">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kullanicilar as $kullanici)
                                    <tr class="kullanici-satir">
                                        <td>
                                            <input type="checkbox" name="secili_kullanicilar[]" value="{{ $kullanici->id }}" class="kullanici-sec">
                                        </td>
                                        <td>{{ $kullanici->id }}</td>
                                        <td>{{ $kullanici->name }}</td>
                                        <td>{{ $kullanici->email }}</td>
                                        <td>{{ $kullanici->phone }}</td>
                                        <td data-rol="{{ $kullanici->role }}">
                                            <span class="badge badge-{{ $kullanici->role }}">
                                                {{ $kullanici->role == 'admin' ? 'Admin' : ($kullanici->role == 'yonetici' ? 'Yönetici' : 'Kullanıcı') }}
                                            </span>
                                        </td>
                                        <td data-tarih="{{ $kullanici->created_at->format('Y-m-d') }}">{{ $kullanici->created_at->format('d.m.Y') }}</td>
                                        <td>
                                            <a href="{{ route('users.goruntule', $kullanici->id) }}" class="btn btn-primary btn-xs" title="Görüntüle">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-xs rol-guncelle"
                                                    data-id="{{ $kullanici->id }}"
                                                    data-rol="{{ $kullanici->role }}"
                                                    title="Rol Güncelle">
                                                <i class="fa fa-cog"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs kullanici-sil"
                                                    data-id="{{ $kullanici->id }}"
                                                    title="Sil">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
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
            <form id="rol-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role">Rol</label>
                        <select name="role" id="role" class="form-control">
                            <option value="admin">Admin</option>
                            <option value="yonetici">Yönetici</option>
                            <option value="kullanici">Kullanıcı</option>
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
                <form id="sil-form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-danger">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Toplu Silme Onay Modal -->
<div class="modal fade" id="toplu-sil-modal" tabindex="-1" role="dialog" aria-labelledby="toplu-sil-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="toplu-sil-modal-label">Seçili Kullanıcıları Silme Onayı</h4>
            </div>
            <div class="modal-body">
                <p id="toplu-sil-mesaj">Seçtiğiniz kullanıcıları silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!</p>
                <p class="text-danger"><strong>Uyarı:</strong> Kullanıcılara ait tüm iletişim bilgileri geçerli kalacak ancak kullanıcı bağlantıları kaldırılacaktır.</p>
                <p><strong>Not:</strong> Bu işlem kullanıcıların randevularını, rezervasyonlarını ve diğer verilerini de silecektir.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
                <button type="button" id="toplu-sil-onay" class="btn btn-danger">Sil</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Basit filtreleme fonksiyonu
    function filtreleKullanicilar() {
        var rolFiltresi = $('#rol-filtresi').val();
        var tarihFiltresi = $('#tarih-filtresi').val();

        $('.kullanici-satir').each(function() {
            var satir = $(this);
            var rol = satir.find('td[data-rol]').attr('data-rol');
            var tarih = satir.find('td[data-tarih]').attr('data-tarih');
            
            var rolUygun = !rolFiltresi || rol === rolFiltresi;
            var tarihUygun = !tarihFiltresi || tarih === tarihFiltresi;
            
            if (rolUygun && tarihUygun) {
                satir.show();
            } else {
                satir.hide();
            }
        });
    }

    // Rol filtresi
    $('#rol-filtresi').on('change', function() {
        filtreleKullanicilar();
    });

    // Tarih filtresi
    $('#tarih-filtresi').on('change', function() {
        filtreleKullanicilar();
    });
    
    // Filtreleri temizle
    $('#filtre-temizle').on('click', function() {
        $('#rol-filtresi').val('');
        $('#tarih-filtresi').val('');
        $('.kullanici-satir').show();
    });

    // Tümünü seç
    $('#tumunu-sec').on('click', function() {
        $('.kullanici-sec').prop('checked', this.checked);
    });

    // Rol güncelleme modal
    $('.rol-guncelle').on('click', function() {
        var id = $(this).data('id');
        var rol = $(this).data('rol');
        $('#role').val(rol);
        $('#rol-form').attr('action', '/panel/kullanicilar/' + id + '/durum');
        $('#rol-modal').modal('show');
    });

    // Kullanıcı silme modal
    $('.kullanici-sil').on('click', function() {
        var id = $(this).data('id');
        $('#sil-form').attr('action', '/panel/kullanicilar/' + id);
        $('#sil-modal').modal('show');
    });

    // Toplu silme
    $('#toplu-sil-btn').on('click', function() {
        var seciliKullanicilar = $('.kullanici-sec:checked').length;
        if(seciliKullanicilar > 0) {
            $('#toplu-sil-mesaj').text(seciliKullanicilar + ' kullanıcıyı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!');
            $('#toplu-sil-modal').modal('show');
        } else {
            alert('Lütfen silmek istediğiniz kullanıcıları seçin.');
        }
    });
    
    // Toplu silme onay
    $('#toplu-sil-onay').on('click', function() {
        $('#kullanicilar-form').submit();
    });
});
</script>
@endsection
