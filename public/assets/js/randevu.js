document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.reservation-form');
    const totalPriceElement = document.querySelector('.total-price');
    const packageDetails = document.getElementById('packageDetails');
    const packageSection = document.getElementById('package-section');
    const totalPriceSection = document.getElementById('total-price-section');
    const submitButtonSection = document.getElementById('submit-button-section');
    const messageSection = document.getElementById('message-section');
    const detailSections = document.querySelectorAll('.detail-section');
    let total = 0;
    let selectedPackage = '';

    // Uyarı modalı için bootstrap modal nesnesi
    const uyariModal = new bootstrap.Modal(document.getElementById('uyariModal'), {
        keyboard: false
    });

    // Uyarı mesajı gösterme fonksiyonu
    function showUyari(mesaj) {
        document.getElementById('uyariMesaji').textContent = mesaj;
        uyariModal.show();
    }

    // Dolu tarihler için kısıtlamalar
    const dateInput = form.querySelector('input[name="date"]');
    const timeInput = form.querySelector('input[name="time"]');
    const timeInfo = document.getElementById('time-info');

    // Bugünün tarihini al
    const today = new Date();
    const todayStr = formatDateForInput(today);

    // Minimum tarih olarak bugünü ayarla
    if (dateInput) {
        dateInput.min = todayStr;

        // Dolu tarihleri al
        let doluTarihler = [];
        try {
            const doluTarihlerStr = dateInput.getAttribute('data-dolu-tarihler');
            if (doluTarihlerStr) {
                doluTarihler = JSON.parse(doluTarihlerStr);
            }
        } catch (e) {
            console.error('Dolu tarihler yüklenirken bir hata oluştu:', e);
        }

        // Tarih değiştiğinde dolu tarih kontrolü yap
        dateInput.addEventListener('input', function() {
            const selectedDate = this.value;

            // Eğer seçilen tarih dolu ise uyarı ver ve seçimi iptal et
            if (doluTarihler.includes(selectedDate)) {
                showUyari('Bu tarih için zaten randevu bulunmaktadır. Lütfen başka bir tarih seçin.');
                this.value = ''; // Tarih seçimini temizle

                // Saat alanını devre dışı bırak
                timeInput.disabled = true;
                timeInput.value = '';
                timeInfo.textContent = 'Lütfen önce bir tarih seçin';
                timeInfo.style.color = '';

                // Paket bölümünü, toplam fiyat ve gönder butonunu gizle
                packageSection.style.display = 'none';
                packageSection.style.opacity = '0';
                packageDetails.style.display = 'none';
                totalPriceSection.style.display = 'none';
                totalPriceSection.style.opacity = '0';
                submitButtonSection.style.display = 'none';
                submitButtonSection.style.opacity = '0';
                messageSection.style.display = 'none';
                messageSection.style.opacity = '0';
            } else if (selectedDate) {
                // Geçerli bir tarih seçildiğinde saat alanını aktifleştir
                timeInput.disabled = false;
                timeInfo.textContent = 'Lütfen randevu saatinizi seçin (09:00-21:00)';
                timeInfo.style.color = '#28a745';
            } else {
                // Tarih alanı boşaltıldığında saat alanını devre dışı bırak
                timeInput.disabled = true;
                timeInput.value = '';
                timeInfo.textContent = 'Lütfen önce bir tarih seçin';
                timeInfo.style.color = '';

                // Paket bölümünü, toplam fiyat ve gönder butonunu gizle
                packageSection.style.display = 'none';
                packageSection.style.opacity = '0';
                packageDetails.style.display = 'none';
                totalPriceSection.style.display = 'none';
                totalPriceSection.style.opacity = '0';
                submitButtonSection.style.display = 'none';
                submitButtonSection.style.opacity = '0';
                messageSection.style.display = 'none';
                messageSection.style.opacity = '0';
            }
        });
    }

    // Saat input alanı için event listener
    if (timeInput) {
        timeInput.addEventListener('input', function() {
            const selectedTime = this.value;

            // Saat seçildiğinde sadece paket seçim bölümünü göster
            if (selectedTime) {
                // Saat formatını parse et
                const [hours, minutes] = selectedTime.split(':').map(Number);
                
                // Saat 09:00 ile 21:00 arasında mı kontrol et
                const minHour = 9;
                const maxHour = parseInt(timeInput.getAttribute('data-max-hour') || "21");
                
                if (hours < minHour || hours > maxHour || (hours === maxHour && minutes > 0)) {
                    showUyari(`Lütfen çalışma saatleri içinde (09:00-${maxHour}:00) bir saat seçin.`);
                    this.value = '';
                    return;
                }

                // Sadece paket seçim bölümünü animasyonla göster
                packageSection.style.display = 'block';

                setTimeout(() => {
                    packageSection.style.opacity = '1';
                }, 10);
            } else {
                // Saat alanı boşaltıldığında paket bölümünü ve diğer bölümleri gizle
                packageSection.style.opacity = '0';
                totalPriceSection.style.opacity = '0';
                submitButtonSection.style.opacity = '0';
                messageSection.style.opacity = '0';

                setTimeout(() => {
                    packageSection.style.display = 'none';
                    totalPriceSection.style.display = 'none';
                    submitButtonSection.style.display = 'none';
                    messageSection.style.display = 'none';
                }, 500);
            }
        });
    }

    // Tarih formatını yyyy-mm-dd şeklinde döndür (input için)
    function formatDateForInput(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // Kullanıcı bilgilerini form alanlarına otomatik doldur
    function fillUserInfo() {
        const nameInput = form.querySelector('input[name="name"]');
        const emailInput = form.querySelector('input[name="email"]');
        const phoneInput = form.querySelector('input[name="phone"]');

        // Data attribute'lardan kullanıcı bilgilerini al
        const userName = nameInput.getAttribute('data-user-name');
        const userEmail = emailInput.getAttribute('data-user-email');
        const userPhone = phoneInput.getAttribute('data-user-phone');

        // Bilgiler varsa form alanlarını doldur
        if (userName) nameInput.value = userName;
        if (userEmail) emailInput.value = userEmail;
        if (userPhone) phoneInput.value = userPhone;
    }

    // Sayfa yüklendiğinde kullanıcı bilgilerini doldur
    fillUserInfo();

    // Veritabanından gelen ilk seçeneklerin ID'lerini al
    function getFirstOptionValue(name) {
        const input = form.querySelector(`input[name="${name}"]`);
        return input ? input.value : null;
    }

    // İlk seçenek değerlerini dinamik olarak al
    const firstEventTypeId = getFirstOptionValue('event_type');
    const firstVenueId = getFirstOptionValue('venue');
    const firstDecorationId = getFirstOptionValue('decoration');
    const firstMenuId = getFirstOptionValue('menu');
    const firstCakeId = getFirstOptionValue('cake');

    // Konumlara göre seçenekleri seçmek için yardımcı fonksiyon
    function selectItemByPosition(name, position) {
        const group = form.querySelector(`.detail-section .image-radio-group input[name="${name}"]`).closest('.image-radio-group');
        const items = group.querySelectorAll('.image-radio');
        
        // Toplam öge sayısını al
        const totalItems = items.length;
        let targetIndex;

        // Konum bazlı index hesapla
        if (position === 'left') {
            targetIndex = 0; // En sol
        } else if (position === 'middle') {
            targetIndex = Math.floor(totalItems / 3); // Ortaya yakın
        } else if (position === 'right') {
            targetIndex = totalItems - 1; // En sağ
        }

        // İlgili input'u seç
        if (items[targetIndex]) {
            const input = items[targetIndex].querySelector('input[type="radio"]');
            if (input) input.checked = true;
            return input ? input.value : null;
        }
        return null;
    }

    // Paket içerikleri - pozisyona göre güncellenmiş
    const packageContents = {
        'ekonomik': {
            event_type: firstEventTypeId, // Organizasyon türü için varsayılan
            venue: null, // Değerleri pozisyona göre ayarlayacağız
            decoration: null,
            menu: null,
            cake: null,
            basePrice: 150000,
            editable: false,
            position: 'left' // Sol taraftaki öğeleri seç
        },
        'standart': {
            event_type: firstEventTypeId,
            venue: null,
            decoration: null,
            menu: null,
            cake: null,
            basePrice: 250000,
            editable: false,
            position: 'middle' // Ortadaki öğeleri seç
        },
        'premium': {
            event_type: firstEventTypeId,
            venue: null,
            decoration: null,
            menu: null,
            cake: null,
            basePrice: 350000,
            editable: false,
            position: 'right' // Sağ taraftaki öğeleri seç
        },
        'ozel': {
            basePrice: 100000,
            editable: true
        }
    };

    // Varsayılan olarak hiçbir paket seçilmemiş durumda başlat
    packageDetails.style.display = 'none';
    
    // Paket seçimi değiştiğinde
    form.querySelectorAll('input[name="package"]').forEach(input => {
        // Başlangıçta hiçbir paket seçili olmamalı
        input.checked = false;
        
        input.addEventListener('change', function() {
            if (this.checked) {
                selectedPackage = this.value;

                // Detay bölümlerini göster
                packageDetails.style.display = 'block';
                detailSections.forEach(section => {
                    section.style.display = 'block';
                });

                // Eklemek İstedikleriniz, Toplam Fiyat ve Gönder butonunu göster
                messageSection.style.display = 'block';
                totalPriceSection.style.display = 'block';
                submitButtonSection.style.display = 'block';

                setTimeout(() => {
                    messageSection.style.opacity = '1';
                    totalPriceSection.style.opacity = '1';
                    submitButtonSection.style.opacity = '1';
                }, 10);

                if (packageContents[selectedPackage]) {
                    // Paket içeriğini seç
                    const content = packageContents[selectedPackage];

                    if (content.editable) {
                        // Özel paket için tüm seçenekleri etkinleştir
                        enableAllOptions();
                    } else {
                        // Hazır paket için konuma göre seçenekleri ayarla
                        const position = content.position;
                        content.venue = selectItemByPosition('venue', position);
                        content.decoration = selectItemByPosition('decoration', position);
                        content.menu = selectItemByPosition('menu', position);
                        content.cake = selectItemByPosition('cake', position);
                        
                        // Organizasyon türü seçimini serbest bırak, diğerlerini devre dışı bırak
                        const optionGroups = form.querySelectorAll(`.detail-section .image-radio-group`);
                        optionGroups.forEach((group, index) => {
                            // İlk grup organizasyon türüdür, onu atla
                            if (index === 0) return;
                            
                            const inputs = group.querySelectorAll('input[type="radio"]');
                            inputs.forEach(radioInput => {
                                const radioContainer = radioInput.closest('.image-radio');
                                if (radioInput.checked) {
                                    radioContainer.classList.remove('disabled-option');
                                } else {
                                    radioContainer.classList.add('disabled-option');
                                }
                            });
                        });
                    }

                    // Başlangıç fiyatını ayarla
                    total = content.basePrice;
                    totalPriceElement.textContent = new Intl.NumberFormat('tr-TR').format(total) + ' TL';
                    // Hidden input değerini de güncelle
                    const totalPriceInput = document.getElementById('total-price-input');
                    if (totalPriceInput) {
                        totalPriceInput.value = total;
                    }
                    
                    // Toplam fiyatı güncelle
                    updateTotal();
                }
            }
        });
    });

    // Tüm seçenekleri etkinleştir
    function enableAllOptions() {
        const optionGroups = form.querySelectorAll(`.image-radio-group`);
        optionGroups.forEach(group => {
            const inputs = group.querySelectorAll('input[type="radio"]');
            inputs.forEach(radioInput => {
                const radioContainer = radioInput.closest('.image-radio');
                radioContainer.classList.remove('disabled-option');
            });
        });
    }

    // Seçimlerin fiyat güncellemesi
    form.addEventListener('change', function(e) {
        if (e.target.type === 'radio' && e.target.name !== 'package') {
            updateTotal();
        }
    });

    function updateTotal() {
        let newTotal = 0;
        const selectedPackageInput = form.querySelector('input[name="package"]:checked');
        const totalPriceInput = document.getElementById('total-price-input');

        if (selectedPackageInput) {
            const packageType = selectedPackageInput.value;
            const packageContent = packageContents[packageType];

            // Paket fiyatını al
            newTotal = packageContent.basePrice;

            // Eğer özel paket ise veya organizasyon türü değiştirildiyse ek ücretleri ekle
            if (packageContent.editable) {
                // Seçilen tüm öğelerin fiyatlarını ekle
                const selectedInputs = form.querySelectorAll('input[type="radio"]:checked:not([name="package"])');
                selectedInputs.forEach(input => {
                    const priceElement = input.nextElementSibling.querySelector('.price');
                    if (priceElement) {
                        // Fiyat stringini düzgün şekilde temizle ve sayıya çevir
                        const priceText = priceElement.textContent.trim();
                        const price = parseInt(priceText.replace(/[^0-9]/g, ''));
                        newTotal += price;
                    }
                });
            } else {
                // Hazır paket için sadece organizasyon türü değişikliğini hesapla
                const eventTypeInput = form.querySelector('input[name="event_type"]:checked');
                if (eventTypeInput) {
                    const priceElement = eventTypeInput.nextElementSibling.querySelector('.price');
                    if (priceElement) {
                        // Fiyat stringini düzgün şekilde temizle ve sayıya çevir
                        const priceText = priceElement.textContent.trim();
                        const price = parseInt(priceText.replace(/[^0-9]/g, ''));
                        newTotal += price;
                    }
                }
            }
        }

        total = newTotal;
        // Görünür fiyat alanını güncelle
        totalPriceElement.textContent = new Intl.NumberFormat('tr-TR').format(total) + ' TL';
        // Hidden input değerini güncelle
        if (totalPriceInput) {
            totalPriceInput.value = total;
        }
    }
});
