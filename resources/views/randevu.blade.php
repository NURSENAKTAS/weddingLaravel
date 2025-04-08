@extends('layouts.layout')

@section('main')
    <main id="main">
        <!-- Uyarı Modalı -->
        <div class="modal fade" id="uyariModal" tabindex="-1" aria-labelledby="uyariModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" id="modalHeader" class="bg-danger text-white">
                        <h5 class="modal-title" id="uyariModalLabel">Uyarı</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="uyariMesaji"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tamam</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="book-a-table section">
            <div class="container">
                <div class="section-title text-center" data-aos="fade-up">
                    <h2>Randevu Oluşturun</h2>
                    <p><span>Hayalinizdeki</span> <span>Organizasyon İçin</span></p>
                </div>

                <div class="row g-0">
                    <div class="col-lg-10 offset-lg-1">
                        <form action="{{ route('randevu.store') }}" method="post" class="reservation-form">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-lg-6">
                                    <input type="text" name="name" class="form-control" placeholder="Adınız Soyadınız" required
                                        data-user-name="{{ $kullanici->name ?? '' }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="email" class="form-control" name="email" placeholder="Email Adresiniz" required
                                        data-user-email="{{ $kullanici->email ?? '' }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" name="phone" placeholder="Telefon Numaranız" required
                                        data-user-phone="{{ $kullanici->phone ?? '' }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="date" class="form-control" name="date" required
                                           data-dolu-tarihler="{{ $doluTarihlerJSON }}">
                                </div>
                                <div class="col-lg-6">
                                    <input type="time" class="form-control" name="time" min="09:00" max="21:00" step="60" data-max-hour="21" required disabled>
                                    <small class="text-muted mt-1" id="time-info">Lütfen önce bir tarih seçin</small>
                                </div>

                                <!-- Paket Seçimi (Başlangıçta gizli) -->
                                <div id="package-section" class="col-12" style="display: none; opacity: 0; transition: opacity 0.5s ease;">
                                    <h4 class="selection-title">Organizasyon Paketi Seçin</h4>
                                    <p class="package-description text-center mb-4">Hazır paketlerimizden birini seçebilir veya kendi tercihinize göre seçimler yapabilirsiniz.</p>
                                    <div class="row package-options">
                                        <div class="col-lg-3">
                                            <div class="package-option">
                                                <input type="radio" name="package" id="package1" value="ekonomik">
                                                <label for="package1">
                                                    <span class="package-title">Ekonomik Paket</span>
                                                    <div class="package-details">
                                                        <ul>
                                                            <li>✓ Organizasyon Türünüz</li>
                                                            <li>✓ Aşk Bahçesi Mekanı</li>
                                                            <li>✓ Beyaz Düşler Süslemesi</li>
                                                            <li>✓ Kraliyet Sofrası Menüsü</li>
                                                            <li>✓ Lavanta Düşü Pastası</li>
                                                        </ul>
                                                        <span class="package-info">Paket Fiyatı</span>
                                                        <span class="price">150.000 TL</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="package-option">
                                                <input type="radio" name="package" id="package2" value="standart">
                                                <label for="package2">
                                                    <span class="package-title">Standart Paket</span>
                                                    <div class="package-details">
                                                        <ul>
                                                            <li>✓ Organizasyon Türünüz</li>
                                                            <li>✓ Sonsuzluk Salonu</li>
                                                            <li>✓ Pastel Bahar Süslemesi</li>
                                                            <li>✓ Aşkın Tadı Menüsü</li>
                                                            <li>✓ Ebedi Aşk Pastası</li>
                                                        </ul>
                                                        <span class="package-info">Paket Fiyatı</span>
                                                        <span class="price">250.000 TL</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="package-option">
                                                <input type="radio" name="package" id="package3" value="premium">
                                                <label for="package3">
                                                    <span class="package-title">Premium Paket</span>
                                                    <div class="package-details">
                                                        <ul>
                                                            <li>✓ Organizasyon Türünüz</li>
                                                            <li>✓ Royale Palace</li>
                                                            <li>✓ Pembe Fısıltı Süslemesi</li>
                                                            <li>✓ Eğlence Tabağı Menüsü</li>
                                                            <li>✓ Zümrüt Kraliçesi Pastası</li>
                                                        </ul>
                                                        <span class="package-info">Paket Fiyatı</span>
                                                        <span class="price">350.000 TL</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="package-option special-package">
                                                <input type="radio" name="package" id="package4" value="ozel">
                                                <label for="package4">
                                                    <span class="package-title">Özel Paket</span>
                                                    <div class="package-details">
                                                        <ul>
                                                            <li>✓ Organizasyon Türünüz</li>
                                                            <li>✓ Mekan Seçin</li>
                                                            <li>✓ Süsleme Seçin</li>
                                                            <li>✓ Menü Seçin</li>
                                                            <li>✓ Pasta Seçin</li>
                                                            <li class="package-note">Tüm içeriği kendiniz belirleyin!</li>
                                                        </ul>
                                                        <span class="package-info">Başlangıç Fiyatı</span>
                                                        <span class="price">100.000 TL</span>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="packageDetails" style="display: none;">
                                    <!-- Organizasyon Türü -->
                                    <div class="col-12 detail-section">
                                        <h4 class="selection-title">Organizasyon Türü</h4>
                                        <div class="row image-radio-group">
                                            @foreach($organizasyonlar as $index => $organizasyon)
                                            <div class="col-lg-3 col-md-6">
                                                <div class="image-radio">
                                                    <input type="radio" name="event_type" id="event{{ $index + 1 }}" value="{{ strtolower($organizasyon->organizasyon_türü) }}" {{ $index == 0 ? 'required' : '' }}>
                                                    <label for="event{{ $index + 1 }}">
                                                        <img src="{{asset('assets/img/parti/' . $organizasyon->resim_url)}}" alt="{{ $organizasyon->organizasyon_türü }}">
                                                        <span>{{ $organizasyon->organizasyon_türü }}</span>
                                                        <span class="price">{{ number_format($organizasyon->fiyat, 0, ',', '.') }} TL</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Mekan Seçimi -->
                                    <div class="col-12 detail-section">
                                        <h4 class="selection-title">Mekan Seçimi</h4>
                                        <div class="row image-radio-group">
                                            @foreach($mekanlar as $index => $mekan)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="image-radio">
                                                    <input type="radio" name="venue" id="venue{{ $index + 1 }}" value="{{ $mekan->id }}" {{ $index == 0 ? 'required' : '' }}>
                                                    <label for="venue{{ $index + 1 }}">
                                                        <img src="{{asset('assets/img/mekan/' . $mekan->resim_url)}}" alt="{{ $mekan->ad }}">
                                                        <span>{{ $mekan->ad }}</span>
                                                        <span class="price">{{ number_format($mekan->fiyat, 0, ',', '.') }} TL</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Süsleme Seçimi -->
                                    <div class="col-12 detail-section">
                                        <h4 class="selection-title">Süsleme Seçimi</h4>
                                        <div class="row image-radio-group">
                                            @foreach($suslemeler as $index => $susleme)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="image-radio">
                                                    <input type="radio" name="decoration" id="deco{{ $index + 1 }}" value="{{ $susleme->id }}" {{ $index == 0 ? 'required' : '' }}>
                                                    <label for="deco{{ $index + 1 }}">
                                                        <img src="{{asset('assets/img/suslemeler/' . $susleme->resim_url)}}" alt="{{ $susleme->ad }}">
                                                        <span>{{ $susleme->ad }}</span>
                                                        <span class="price">{{ number_format($susleme->fiyat, 0, ',', '.') }} TL</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Yemek Menüsü -->
                                    <div class="col-12 detail-section">
                                        <h4 class="selection-title">Yemek Menüsü</h4>
                                        <div class="row image-radio-group">
                                            @foreach($yemekler as $index => $yemek)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="image-radio">
                                                    <input type="radio" name="menu" id="menu{{ $index + 1 }}" value="{{ $yemek->id }}" {{ $index == 0 ? 'required' : '' }}>
                                                    <label for="menu{{ $index + 1 }}">
                                                        <img src="{{asset('assets/img/yemekler/' . $yemek->resim_url)}}" alt="{{ $yemek->ad }}">
                                                        <span>{{ $yemek->ad }}</span>
                                                        <span class="price">{{ number_format($yemek->fiyat, 0, ',', '.') }} TL</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Pasta Seçimi -->
                                    <div class="col-12 detail-section">
                                        <h4 class="selection-title">Pasta Seçimi</h4>
                                        <div class="row image-radio-group">
                                            @foreach($pastalar as $index => $pasta)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="image-radio">
                                                    <input type="radio" name="cake" id="cake{{ $index + 1 }}" value="{{ $pasta->id }}" {{ $index == 0 ? 'required' : '' }}>
                                                    <label for="cake{{ $index + 1 }}">
                                                        <img src="{{asset('assets/img/pastalar/' . $pasta->resim_url)}}" alt="{{ $pasta->ad }}">
                                                        <span>{{ $pasta->ad }}</span>
                                                        <span class="price">{{ number_format($pasta->fiyat, 0, ',', '.') }} TL</span>
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div id="message-section" class="col-lg-12" style="display: none; opacity: 0; transition: opacity 0.5s ease;">
                                    <textarea class="form-control" name="message" rows="5" placeholder="Eklemek İstedikleriniz"></textarea>
                                </div>
                                <div id="total-price-section" class="col-12" style="display: none; opacity: 0; transition: opacity 0.5s ease;">
                                    <div class="total-price-section text-center">
                                        <h3>Toplam Tutar</h3>
                                        <div class="total-price">0 TL</div>
                                        <input type="hidden" name="total-price" id="total-price-input" value="0">
                                    </div>
                                </div>
                                <div id="submit-button-section" class="col-12 text-center" style="display: none; opacity: 0; transition: opacity 0.5s ease;">
                                    <button type="submit">Gönder</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('js')
    <!-- Vendor JS Files -->
    <script src="{{asset("assets/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("assets/vendor/php-email-form/validate.js")}}"></script>
    <script src="{{asset("assets/vendor/aos/aos.js")}}"></script>
    <script src="{{asset("assets/vendor/glightbox/js/glightbox.min.js")}}"></script>
    <script src="{{asset("assets/vendor/purecounter/purecounter_vanilla.js")}}"></script>
    <script src="{{asset("assets/vendor/swiper/swiper-bundle.min.js")}}"></script>

    <!-- Main JS File -->
    <script src="{{asset("assets/js/main.js")}}"></script>
    <script src="{{asset("assets/js/randevu.js")}}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Başarı ve hata mesajlarını kontrol et
            const uyariModal = document.getElementById('uyariModal');
            const modalHeader = document.getElementById('modalHeader');
            const modalTitle = document.getElementById('uyariModalLabel');
            const uyariMesaji = document.getElementById('uyariMesaji');
            const rezervasyonDetaylari = document.getElementById('rezervasyonDetaylari');

            @if(session('success'))
                // Başarı mesajı
                modalHeader.classList.remove('bg-danger');
                modalHeader.classList.add('bg-success', 'text-white');
                modalTitle.textContent = 'Başarılı!';
                uyariMesaji.textContent = "{{ session('success') }}";
            @endif

            @if(session('error'))
                // Hata mesajı
                modalHeader.classList.remove('bg-success');
                modalHeader.classList.add('bg-danger', 'text-white');
                modalTitle.textContent = 'Hata!';
                uyariMesaji.textContent = "{{ session('error') }}";
                rezervasyonDetaylari.style.display = 'none';
            @endif
        });
    </script>
@endsection
