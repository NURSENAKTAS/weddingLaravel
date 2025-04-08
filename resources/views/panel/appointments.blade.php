@extends('panel.layout')

@section('title', 'Randevular - Yönetim Paneli')

@section('styles')
<style>
    .badge-default {
        background-color: #999;
    }
    .badge-beklemede {
        background-color: #f0ad4e;
    }
    .badge-onaylandı, .badge-onaylandi {
        background-color: #5cb85c;
    }
    .badge-reddedildi {
        background-color: #d9534f;
    }
    .badge-tamamlandı, .badge-tamamlandi {
        background-color: #5bc0de;
    }
    .badge-iptal {
        background-color: #777;
    }
</style>
<!-- Flatpickr takvim için CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Randevular <small>Tüm randevuları yönetin</small>
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
                                <label>Durum</label>
                                <select id="durum-filtresi" class="form-control">
                                    <option value="">Tümü</option>
                                    <option value="beklemede">Beklemede</option>
                                    <option value="onaylandı">Onaylandı</option>
                                    <option value="reddedildi">Reddedildi</option>
                                    <option value="iptal">İptal Edildi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tarih</label>
                                <input type="date" id="tarih-filtresi" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" id="filtre-temizle" class="form-control btn btn-default">Filtreleri Temizle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Randevular Tablosu -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-calendar"></i> Randevular
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
                        <form id="randevular-form" method="POST" action="{{ route('appointments.toplu-sil') }}">
                            @csrf
                            <table class="table table-striped table-bordered table-hover" id="randevular-tablosu">
                                <thead>
                                    <tr>
                                        <th width="20">
                                            <input type="checkbox" id="tumunu-sec">
                                        </th>
                                        <th width="50">ID</th>
                                        <th>Kullanıcı</th>
                                        <th>E-posta</th>
                                        <th>Telefon</th>
                                        <th>Randevu Tarihi</th>
                                        <th>Özel İstekler</th>
                                        <th width="100">Durum</th>
                                        <th width="120">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($randevular as $randevu)
                                    <tr class="randevu-satir">
                                        <td>
                                            <input type="checkbox" name="secili_randevular[]" value="{{ $randevu->id }}" class="randevu-sec">
                                        </td>
                                        <td>{{ $randevu->id }}</td>
                                        <td>{{ $randevu->kullanici->name }}</td>
                                        <td>{{ $randevu->kullanici->email }}</td>
                                        <td>{{ $randevu->kullanici->phone }}</td>
                                        <td data-tarih="{{ \Carbon\Carbon::parse($randevu->randevu_tarihi)->format('Y-m-d') }}">
                                            {{ \Carbon\Carbon::parse($randevu->randevu_tarihi)->format('d.m.Y H:i') }}
                                        </td>
                                        <td>{{ $randevu->ozel_istekler }}</td>
                                        <td data-durum="{{ strtolower($randevu->rezervasyon_durum) }}">
                                            @if($randevu->Rezervasyonlar->count() > 0)
                                                <span class="badge badge-{{ $randevu->rezervasyon_durum }}">
                                                    {{ ucfirst($randevu->Rezervasyonlar->first()->rezervasyon_durum) }}
                                                </span>
                                            @else
                                                <span class="badge badge-default">Belirsiz</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('appointments.goruntule', $randevu->id) }}" class="btn btn-primary btn-xs" title="Görüntüle">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-xs durum-guncelle"
                                                    data-id="{{ $randevu->id }}"
                                                    data-durum="{{ $randevu->Rezervasyonlar->first()->rezervasyon_durum ?? 'beklemede' }}"
                                                    title="Durum Güncelle">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs randevu-sil"
                                                    data-id="{{ $randevu->id }}"
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

<!-- Durum Güncelleme Modal -->
<div class="modal fade" id="durum-modal" tabindex="-1" role="dialog" aria-labelledby="durum-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="durum-modal-label">Randevu Durumunu Güncelle</h4>
            </div>
            <form id="durum-form" method="POST">
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
                <h4 class="modal-title" id="toplu-sil-modal-label">Toplu Randevu Silme Onayı</h4>
            </div>
            <div class="modal-body">
                <p><span id="secili-randevu-sayisi"></span> randevuyu silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!</p>
                <div class="alert alert-warning">
                    <i class="fa fa-exclamation-triangle"></i> 
                    <strong>Uyarı:</strong> İlişkili tüm rezervasyon ve ödeme verileri de silinecektir.
                </div>
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
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/tr.js"></script>
<script>
$(document).ready(function() {
    // Tarih seçici için Flatpickr'ı etkinleştir
    var tarihSecici = flatpickr("#tarih-filtresi", {
        locale: "tr",
        dateFormat: "Y-m-d",
        allowInput: true,
        altInput: true,
        altFormat: "d.m.Y"
    });
    
    // Basit filtreleme fonksiyonu
    function filtreleRandevular() {
        var durumFiltresi = $('#durum-filtresi').val().toLowerCase();
        var tarihFiltresi = $('#tarih-filtresi').val();
        
        console.log("Durum Filtresi:", durumFiltresi);
        console.log("Tarih Filtresi:", tarihFiltresi);

        $('.randevu-satir').each(function() {
            var satir = $(this);
            var durum = satir.find('td[data-durum]').attr('data-durum').toLowerCase();
            var tarih = satir.find('td[data-tarih]').attr('data-tarih');
            
            console.log("Satır Durum:", durum);
            console.log("Satır Tarih:", tarih);
            
            var durumUygun = !durumFiltresi || durum.includes(durumFiltresi);
            var tarihUygun = !tarihFiltresi || tarih === tarihFiltresi;
            
            if (durumUygun && tarihUygun) {
                satir.show();
            } else {
                satir.hide();
            }
        });
    }

    // Durum filtresi
    $('#durum-filtresi').on('change', function() {
        filtreleRandevular();
    });

    // Tarih filtresi
    $('#tarih-filtresi').on('change', function() {
        filtreleRandevular();
    });
    
    // Filtreleri temizle
    $('#filtre-temizle').on('click', function() {
        $('#durum-filtresi').val('');
        
        // Flatpickr'ı temizle
        tarihSecici.clear();
        
        // Tüm satırları göster
        $('.randevu-satir').show();
    });

    // Tümünü seç
    $('#tumunu-sec').on('click', function() {
        $('.randevu-sec').prop('checked', this.checked);
    });

    // Durum güncelleme modal
    $('.durum-guncelle').on('click', function() {
        var id = $(this).data('id');
        var durum = $(this).data('durum');
        $('#durum').val(durum);
        $('#durum-form').attr('action', '/panel/randevular/' + id + '/durum');
        $('#durum-modal').modal('show');
    });

    // Randevu silme modal
    $('.randevu-sil').on('click', function() {
        var id = $(this).data('id');
        $('#sil-form').attr('action', '/panel/randevular/' + id);
        $('#sil-modal').modal('show');
    });

    // Toplu silme
    $('#toplu-sil-btn').on('click', function() {
        var seciliRandevular = $('.randevu-sec:checked').length;
        if(seciliRandevular > 0) {
            // Pop-up'ı göster
            $('#secili-randevu-sayisi').text(seciliRandevular);
            $('#toplu-sil-modal').modal('show');
        } else {
            alert('Lütfen silmek istediğiniz randevuları seçin.');
        }
    });
    
    // Toplu silme onayı
    $('#toplu-sil-onay').on('click', function() {
        $('#randevular-form').submit();
        $('#toplu-sil-modal').modal('hide');
    });
});
</script>
@endsection
