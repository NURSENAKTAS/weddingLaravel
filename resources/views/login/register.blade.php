@extends('layouts.layout')

@section('main')

    <section class="register-section">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-md-6 col-lg-5 d-none d-md-block">
                    <div class="text-center">
                        <img src="{{asset('assets/img/register.png')}}" class="img-fluid" alt="Register illustration">
                        <div class="mt-4">
                            <h3 class="fw-bold text-pink">Düğün Organizasyonumuza Hoş Geldiniz</h3>
                            <p class="text-muted">En özel gününüzde yanınızdayız</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-5">
                    <div class="auth-form wedding-theme">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-pink">Hesap Oluşturun</h2>
                            <p class="text-muted">Hemen ücretsiz hesabınızı oluşturun</p>
                        </div>

                        <form action="/register" method="POST">
                            @csrf
                            <!-- Name input -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="username">Ad Soyad</label>
                                <input type="text" name="kulad" id="username"
                                       class="form-control @error('kulad') is-invalid @enderror"
                                       placeholder="Adınızı ve soyadınızı giriniz"
                                       value="{{ old('kulad') }}" />
                                @error('kulad')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone input -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="phone">Telefon Numarası</label>
                                <input type="tel" name="phone" id="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="Telefon numaranızı giriniz"
                                       value="{{ old('phone') }}" />
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email input -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="email">E-posta Adresi</label>
                                <input type="email" name="email" id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="E-posta adresinizi giriniz"
                                       value="{{ old('email') }}" />
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password input -->
                            <div class="form-group mb-3">
                                <label class="form-label" for="sifre">Şifre</label>
                                <input type="password" name="password" id="sifre"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Şifrenizi giriniz" />
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div class="form-group mb-4">
                                <label class="form-label" for="sifre2">Şifre Tekrarı</label>
                                <input type="password" name="password_confirmation" id="sifre2"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       placeholder="Şifrenizi tekrar giriniz" />
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-pink wedding-btn">
                                    Kayıt Ol
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="mb-0">Zaten hesabınız var mı?</p>
                                <a href="/login" class="fw-semibold text-pink">Giriş Yap</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
<!-- Validation script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const phoneInput = document.getElementById('phone');
            // Sadece sayısal değerlere izin ver
            phoneInput.value = phoneInput.value.replace(/\D/g, '');
        });
    });
</script>
@endsection
