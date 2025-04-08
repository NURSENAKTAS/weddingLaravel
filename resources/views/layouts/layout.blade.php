<!DOCTYPE html>
<html lang="en">
@include('layouts.header')
<body>
    <!-- Başarı mesajı için modal -->
    @if(session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header bg-success text-white border-0">
                    <h5 class="modal-title" id="successModalLabel">Başarılı!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success fs-1 me-3"></i>
                        <p class="mb-0 fs-5">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @yield('main')
    @include('layouts.footer')
</body>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div class="preloader">
    <div class="vertical-centered-box">
        <div class="content">
            <div class="loader-circle"></div>
            <div class="loader-line-mask">
                <div class="loader-line"></div>
            </div>
            <img src="{{asset("assets/img/preloader.png")}}" alt="">
        </div>
    </div>
</div>

@yield('js')

<!-- Modal JavaScript -->
@if(session('success') || session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hangi mesaj varsa o modalı seç
        var modalId = '{{ session('success') ? 'successModal' : 'errorModal' }}';
        var modal = new bootstrap.Modal(document.getElementById(modalId));

        // Modalı göster
        modal.show();

        // 5 saniye sonra modalı kapat
        setTimeout(function() {
            modal.hide();
        }, 3000);
    });
</script>
@endif

</html>
