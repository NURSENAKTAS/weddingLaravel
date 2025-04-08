@extends('panel.layout')

@section('title', 'İletişim Mesajları - Yönetim Paneli')

@section('styles')
<style>
    .badge-beklemede {
        background-color: #f0ad4e;
    }
    .badge-yanıtlandı {
        background-color: #5cb85c;
    }
    .badge-kapatıldı {
        background-color: #d9534f;
    }
    .message-preview {
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                İletişim Mesajları <small>Kullanıcılardan gelen mesajlar</small>
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
                                    <option value="yanıtlandı">Yanıtlandı</option>
                                    <option value="kapatıldı">Kapatıldı</option>
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
                                <button type="button" id="filtre-temizle" class="btn btn-default form-control">Filtreleri Temizle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mesajlar Tablosu -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-envelope"></i> Mesajlar
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" class="btn btn-success btn-sm" id="tumunu-okundu-btn" title="Beklemedeki tüm mesajları yanıtlandı olarak işaretler">
                                <i class="fa fa-check-square-o"></i> Tümünü Okundu Olarak İşaretle
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" id="toplu-sil-btn">
                                <i class="fa fa-trash"></i> Seçilenleri Sil
                            </button>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <form id="mesajlar-form" method="POST" action="{{ route('iletisim.toplu-sil') }}">
                            @csrf
                            <table class="table table-striped table-bordered table-hover" id="mesajlar-tablosu">
                                <thead>
                                    <tr>
                                        <th width="20">
                                            <input type="checkbox" id="tumunu-sec">
                                        </th>
                                        <th width="50">ID</th>
                                        <th>Ad Soyad</th>
                                        <th>Email</th>
                                        <th>Konu</th>
                                        <th>Mesaj</th>
                                        <th width="120">Tarih</th>
                                        <th width="100">Durum</th>
                                        <th width="120">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mesajlar as $mesaj)
                                    <tr class="mesaj-satir">
                                        <td>
                                            <input type="checkbox" name="secili_mesajlar[]" value="{{ $mesaj->id }}" class="mesaj-sec">
                                        </td>
                                        <td>{{ $mesaj->id }}</td>
                                        <td>{{ $mesaj->ad_soyad }}</td>
                                        <td>{{ $mesaj->email }}</td>
                                        <td>{{ $mesaj->konu }}</td>
                                        <td class="message-preview">{{ $mesaj->mesaj }}</td>
                                        <td data-tarih="{{ $mesaj->created_at->format('Y-m-d') }}">{{ $mesaj->created_at->format('d.m.Y') }}</td>
                                        <td data-durum="{{ $mesaj->durum }}">
                                            <span class="badge badge-{{ $mesaj->durum }}">
                                                {{ ucfirst($mesaj->durum) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('iletisim.goruntule', $mesaj->id) }}" class="btn btn-primary btn-xs" title="Görüntüle">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-success btn-xs durum-guncelle" 
                                                    data-id="{{ $mesaj->id }}" 
                                                    data-durum="{{ $mesaj->durum }}" 
                                                    title="Durum Güncelle">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs mesaj-sil" 
                                                    data-id="{{ $mesaj->id }}" 
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
                <h4 class="modal-title" id="durum-modal-label">Mesaj Durumunu Güncelle</h4>
            </div>
            <form id="durum-form" method="POST">
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
                <h4 class="modal-title" id="toplu-sil-modal-label">Seçili Mesajları Silme Onayı</h4>
            </div>
            <div class="modal-body">
                <p id="toplu-sil-mesaj">Seçtiğiniz mesajları silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
                <button type="button" id="toplu-sil-onay" class="btn btn-danger">Sil</button>
            </div>
        </div>
    </div>
</div>

<!-- Tümünü Okundu Olarak İşaretleme Modal -->
<div class="modal fade" id="okundu-modal" tabindex="-1" role="dialog" aria-labelledby="okundu-modal-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="okundu-modal-label">Tümünü Okundu Olarak İşaretle</h4>
            </div>
            <div class="modal-body">
                <p>Beklemedeki tüm mesajları okundu olarak işaretlemek istediğinizden emin misiniz?</p>
                <p class="text-info"><i class="fa fa-info-circle"></i> Bu işlem tüm 'Beklemede' durumundaki mesajları 'Yanıtlandı' durumuna geçirecektir.</p>
            </div>
            <div class="modal-footer">
                <form id="okundu-form" method="POST" action="{{ route('iletisim.tumunu-okundu') }}">
                    @csrf
                    <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">İşaretle</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Basit filtreleme fonksiyonu
    function filtreleMesajlar() {
        var durumFiltresi = $('#durum-filtresi').val();
        var tarihFiltresi = $('#tarih-filtresi').val();

        $('.mesaj-satir').each(function() {
            var satir = $(this);
            var durum = satir.find('td[data-durum]').attr('data-durum');
            var tarih = satir.find('td[data-tarih]').attr('data-tarih');
            
            var durumUygun = !durumFiltresi || durum === durumFiltresi;
            var tarihUygun = !tarihFiltresi || tarih === tarihFiltresi;
            
            if (durumUygun && tarihUygun) {
                satir.show();
            } else {
                satir.hide();
            }
        });
        
        // Görünür satır sayısını güncelle
        var gorunurSatirlar = $('.mesaj-satir:visible').length;
        $('#gorunur-sayisi').text(gorunurSatirlar);
    }

    // Tüm satır sayısını göster
    var toplamSatirlar = $('.mesaj-satir').length;
    $('#toplam-sayisi').text(toplamSatirlar);
    $('#gorunur-sayisi').text(toplamSatirlar);

    // Durum filtresi
    $('#durum-filtresi').on('change', function() {
        filtreleMesajlar();
    });

    // Tarih filtresi
    $('#tarih-filtresi').on('change', function() {
        filtreleMesajlar();
    });
    
    // Filtreleri temizle
    $('#filtre-temizle').on('click', function() {
        $('#durum-filtresi').val('');
        $('#tarih-filtresi').val('');
        $('.mesaj-satir').show();
        $('#gorunur-sayisi').text(toplamSatirlar);
    });

    // Tümünü seç
    $('#tumunu-sec').on('click', function() {
        $('.mesaj-sec:visible').prop('checked', this.checked);
        guncelleTumunuSecDurumu();
    });
    
    // Seçim değiştiğinde tümünü seç durumunu güncelle
    $('.mesaj-sec').on('change', function() {
        guncelleTumunuSecDurumu();
    });
    
    // Tümünü seç checkbox durumunu güncelleme
    function guncelleTumunuSecDurumu() {
        var toplamGorunur = $('.mesaj-sec:visible').length;
        var seciliSayisi = $('.mesaj-sec:visible:checked').length;
        
        if (seciliSayisi === 0) {
            $('#tumunu-sec').prop('checked', false);
            $('#tumunu-sec').prop('indeterminate', false);
        } else if (seciliSayisi === toplamGorunur) {
            $('#tumunu-sec').prop('checked', true);
            $('#tumunu-sec').prop('indeterminate', false);
        } else {
            $('#tumunu-sec').prop('checked', false);
            $('#tumunu-sec').prop('indeterminate', true);
        }
    }

    // Durum güncelleme modal
    $('.durum-guncelle').on('click', function() {
        var id = $(this).data('id');
        var durum = $(this).data('durum');
        $('#durum').val(durum);
        $('#durum-form').attr('action', '/panel/iletisim/' + id + '/durum');
        $('#durum-modal').modal('show');
    });

    // Mesaj silme modal
    $('.mesaj-sil').on('click', function() {
        var id = $(this).data('id');
        $('#sil-form').attr('action', '/panel/iletisim/' + id);
        $('#sil-modal').modal('show');
    });

    // Toplu silme
    $('#toplu-sil-btn').on('click', function() {
        var seciliMesajlar = $('.mesaj-sec:checked').length;
        if(seciliMesajlar > 0) {
            $('#toplu-sil-mesaj').text(seciliMesajlar + ' mesajı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!');
            $('#toplu-sil-modal').modal('show');
        } else {
            alert('Lütfen silmek istediğiniz mesajları seçin.');
        }
    });
    
    // Toplu silme onay
    $('#toplu-sil-onay').on('click', function() {
        $('#mesajlar-form').submit();
    });
    
    // Tümünü okundu olarak işaretle
    $('#tumunu-okundu-btn').on('click', function() {
        $('#okundu-modal').modal('show');
    });
});
</script>
@endsection 