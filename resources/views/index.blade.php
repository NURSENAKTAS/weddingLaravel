@extends('layouts.layout')

@section('main')

    <main class="main">

        <section id="anasayfa" class="hero-section">
            <div class="container">
                <div class="row gy-4 justify-content-center justify-content-lg-between">
                    <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center">
                        <h1 data-aos="fade-up">Her ayrıntı<br> en güzel gününüz için.</h1>
                        <p data-aos="fade-up" data-aos-delay="100">Düğününüz için her detayda mükemmelliği hedefliyoruz. Hayalinizdeki atmosferi yaratmak için yanınızdayız!</p>
                        @auth
                            <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                                <a href="/randevu" class="hero-btn">Randevu Oluşturun</a>
                            </div>
                        @endauth
                    </div>

                    <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                        <img src="{{asset("assets/img/hero-img.png")}}" class="img-fluid animated" alt="">
                    </div>
                </div>
            </div>

            <div class="shape-1">
                <img src="{{asset("assets/img/shape-1.png")}}" alt="">
            </div>
            <div class="shape-2">
                <img src="{{asset("assets/img/shape-2.png")}}" alt="">
            </div>
            <div class="curved-decoration">
                <svg width="100%" height="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 2560 168.6227" enable-background="new 0 0 2560 168.6227" xml:space="preserve">
              <g>
                  <path d="M0,0c0,0,219.6543,165.951,730.788,124.0771c383.3156-31.4028,827.2139-96.9514,1244.7139-96.9514
                  c212.5106,0,438.9999,3.5,584.4982,1.5844v139.9126H0V0z" fill="#ffffff"/>
              </g>
          </svg>
            </div>
        </section>


        <section id="hakkimizda" class="about section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Hakkımızda<br></h2>
                <p><span>Daha fazla</span> <span class="description-title">öğrenin</span></p>
            </div>

            <div class="container">

                <div class="row gy-4">
                    <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{asset("assets/img/abouttt.jpg")}}" class="img-fluid mb-4" alt="" style="width: 500%; height: 70%; max-width: 600px;">
                        <div class="book-a-table">
                            <h3>İletişim için arayın.</h3>
                            <p>0555555555</p>
                        </div>
                    </div>
                    <div class="col-lg-5" data-aos="fade-up" data-aos-delay="250">
                        <div class="content ps-0 ps-lg-5">
                            <ul>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Romantik ve sıcak bir atmosfer sunan şık bir mekan.</span></li>
                                <br></br>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Misafirlerin konforunu ön planda tutan özel oturma alanları.</span></li><br></br>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Fotoğraf çekimleri için estetik ve göz alıcı dekorasyon.</span></li><br></br>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Hem açık hem kapalı alan seçenekleriyle her mevsime uygun.</span></li><br></br>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Özel günlerinizi unutulmaz kılacak ışıklandırma ve süslemeler.</span></li><br></br>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Müzik ve eğlence için profesyonel ses ve sahne sistemleri.</span></li><br></br>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Misafirlerin kolayca ulaşabileceği merkezi bir konum.</span></li><br></br>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Özel anlarınızı ölümsüzleştirecek profesyonel fotoğraf ve video desteği.</span></li><br></br>
                                <li><i class="bi bi-check-circle-fill"></i> <span>Her detayı titizlikle düşünülmüş, hayallerinizdeki buluşma noktası. </span></li><br></br>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </section>



        <section id="susleme" class="menu section">


            <div class="container section-title" data-aos="fade-up">
                <h2>Menülerimiz</h2>
                <p><span>Lezzetli Menümüzü</span> <span class="description-title">Keşfedin 🍽️</span></p>
            </div>

            <div class="container">

                <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                    <li class="nav-item">
                        <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#menu-breakfast">
                            <h4>Pastalar</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-lunch">
                            <h4>Yemekler</h4>
                        </a>
                    </li>
                </ul>

                <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
                    <div class="tab-pane fade active show" id="menu-breakfast">
                        <div class="tab-header text-center">
                            <p>Menu</p>
                            <h3>Pastalar</h3>
                        </div>
                        <div class="row gy-5">
                            @foreach($pastalar as $pasta)
                            <div class="col-lg-4 menu-item">
                                <a href="{{ asset('assets/img/pastalar/' . $pasta->resim_url) }}" class="glightbox">
                                    <img src="{{ asset('assets/img/pastalar/' . $pasta->resim_url) }}" class="menu-img img-fluid" alt="{{ $pasta->pasta_adi }}">
                                </a>
                                <h4>{{ $pasta->pasta_adi }}</h4>
                                <p class="ingredients">
                                    {{ $pasta->aciklama }}
                                </p>
                                <p class="price">
                                    {{ number_format($pasta->fiyat, 0, ',', '.') }} TL
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="menu-lunch">
                        <div class="tab-header text-center">
                            <p>Menu</p>
                            <h3>Yemekler</h3>
                        </div>
                        <div class="row gy-5">
                            @foreach($menuOgeleri as $menu)
                            <div class="col-lg-4 menu-item">
                                <a href="{{ asset('assets/img/yemekler/' . $menu->resim_url) }}" class="glightbox">
                                    <img src="{{ asset('assets/img/yemekler/' . $menu->resim_url) }}" class="menu-img img-fluid" alt="{{ $menu->menu_adi }}">
                                </a>
                                <h4>{{ $menu->menu_adi }}</h4>
                                <p class="ingredients">
                                    {{ $menu->aciklama }}
                                </p>
                                <p class="price">
                                    {{ number_format($menu->fiyat, 0, ',', '.') }} TL
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

        </section>

        <section id="susleme2" class="menu section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Mekanlarımız ve Süslemelerimiz</h2>
                <p><span>Aşkınıza Ev Sahipliği Yapan</span> <span class="description-title">Büyülü Dokunuşlar✨</span></p>
            </div>

            <div class="container">
                <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
                    <li class="nav-item">
                        <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#menu-breakfast2">
                            <h4>Mekanlar</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" data-bs-target="#menu-lunch2">
                            <h4>Süslemeler</h4>
                        </a>
                    </li>
                </ul>

                <div class="tab-content" data-aos="fade-up" data-aos-delay="200">
                    <div class="tab-pane fade active show" id="menu-breakfast2">
                        <div class="tab-header text-center">
                            <p>Menu</p>
                            <h3>Mekanlar</h3>
                        </div>
                        <div class="row gy-5">
                            @foreach($mekanlar as $mekan)
                            <div class="col-lg-4 menu-item">
                                <a href="{{ asset('assets/img/mekan/' . $mekan->resim_url) }}" class="glightbox">
                                    <img src="{{ asset('assets/img/mekan/' . $mekan->resim_url) }}" class="menu-img img-fluid" alt="{{ $mekan->mekan_adi }}">
                                </a>
                                <h4>{{ $mekan->mekan_adi }}</h4>
                                <p class="ingredients">
                                    {{ $mekan->aciklama }}
                                </p>
                                <p class="price">
                                    {{ number_format($mekan->fiyat, 0, ',', '.') }} TL
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="menu-lunch2">
                        <div class="tab-header text-center">
                            <p>Menu</p>
                            <h3>Süslemeler</h3>
                        </div>
                        <div class="row gy-5">
                            @foreach($suslemeler as $susleme)
                            <div class="col-lg-4 menu-item">
                                <a href="{{ asset('assets/img/suslemeler/' . $susleme->resim_url) }}" class="glightbox">
                                    <img src="{{ asset('assets/img/suslemeler/' . $susleme->resim_url) }}" class="menu-img img-fluid" alt="{{ $susleme->susleme_adi }}">
                                </a>
                                <h4>{{ $susleme->susleme_adi }}</h4>
                                <p class="ingredients">
                                    {{ $susleme->aciklama }}
                                </p>
                                <p class="price">
                                    {{ number_format($susleme->fiyat, 0, ',', '.') }} TL
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="events" class="events section">

            <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

                <div class="swiper init-swiper">
                    <script type="application/json" class="swiper-config">
                        {
                          "loop": true,
                          "speed": 600,
                          "autoplay": {
                            "delay": 5000
                          },
                          "slidesPerView": "auto",
                          "pagination": {
                            "el": ".swiper-pagination",
                            "type": "bullets",
                            "clickable": true
                          },
                          "breakpoints": {
                            "320": {
                              "slidesPerView": 1,
                              "spaceBetween": 40
                            },
                            "1200": {
                              "slidesPerView": 3,
                              "spaceBetween": 1
                            }
                          }
                        }
                    </script>
                    <div class="swiper-wrapper">
                        @foreach($organizasyonlar as $organizasyon)
                        <div class="swiper-slide event-item d-flex flex-column justify-content-end"
                            style="background-image: url('{{ asset('assets/img/parti/' . $organizasyon->resim_url) }}')">
                            <h3>{{ $organizasyon->organizasyon_türü }}</h3>
                            <div class="price align-self-start">{{ number_format($organizasyon->fiyat, 0, ',', '.') }} TL</div>
                            <p class="description">
                                {{ $organizasyon->aciklama }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>

        </section>







        <section id="iletisim" class="contact section">
            <div class="container section-title" data-aos="fade-up">
                <h2>İletişim</h2>
                <p><span>Hayallerinizi</span> <span class="description-title">Gerçekleştirelim</span></p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="mb-5">
                    <iframe style="border:0; width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3051.294364715079!2d26.4204704!3d40.113443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b1a82ca9b99cfd%3A0xf803b1ad12ea8904!2s%C3%87anakkale%20Onsekiz%20Mart%20%C3%9Cniversitesi!5e0!3m2!1str!2str!4v1740584338685!5m2!1str!2str" frameborder="0" allowfullscreen></iframe>
                </div>

                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center">
                            <i class="icon bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Adres</h3>
                                <p>Çanakkale Teknik Bilimler Meslek Yüksekokulu<br>Terzioğlu Yerleşkesi 17020, ÇANAKKALE<br>(Beldemiz Sitesi Üstü)</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center">
                            <i class="icon bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Bizi Arayın</h3>
                                <p>0216 555 55 55</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center">
                            <i class="icon bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email</h3>
                                <p>info@weddingorganization.com</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-item d-flex align-items-center">
                            <i class="icon bi bi-clock flex-shrink-0"></i>
                            <div>
                                <h3>Açılış Saatlerimiz</h3>
                                <p><strong>Pt-Ct:</strong> 11:00 - 23:00<br><strong>Pazar:</strong> Kapalı</p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('iletisim.gonder') }}" method="post" class="contact-form mt-5">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="text" name="ad_soyad" class="form-control" placeholder="Adınız Soyadınız" value="{{ old('ad_soyad') }}" required>
                            @error('ad_soyad')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email Adresiniz" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <input type="text" class="form-control" name="konu" placeholder="Konu" value="{{ old('konu') }}" required>
                        @error('konu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="mesaj" rows="6" placeholder="Mesajınız" required>{{ old('mesaj') }}</textarea>
                        @error('mesaj')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit">Mesaj Gönder</button>
                    </div>
                </form>
            </div>
        </section>

    </main>
@endsection

@section('js')
    <!-- Vendor JS Files -->
    <script src="{{asset("assets/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <script src="{{asset("assets/vendor/aos/aos.js")}}"></script>
    <script src="{{asset("assets/vendor/glightbox/js/glightbox.min.js")}}"></script>
    <script src="{{asset("assets/vendor/purecounter/purecounter_vanilla.js")}}"></script>
    <script src="{{asset("assets/vendor/swiper/swiper-bundle.min.js")}}"></script>

    <!-- Main JS File -->
    <script src="{{asset("assets/js/main.js")}}"></script>
@endsection
