<h1 align="center">
  <br>
  <a href=""><img src="https://github.com/Froxerr/weddingLaravel/blob/main/public/assets/img/logo.png" alt="Wedding Organization System" width="200"></a>
  <br>
  Düğün Organizasyon Sistemi
  <br>
</h1>

<h4 align="center">Düğün Organizasyonları için Kapsamlı Yönetim Sistemi</h4>

<div align="center">
  <span style="display: inline-block; margin-right: 10px;">
    <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  </span>
  <span style="display: inline-block; margin-right: 10px;">
    <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  </span>
  <span style="display: inline-block; margin-right: 10px;">
    <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  </span>
  <span style="display: inline-block;">
    <img src="https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  </span>
</div>


<p align="center">
  <a href="#temel-özellikler">Temel Özellikler</a> •
  <a href="#rol-tabanlı-özellikler">Rol Tabanlı Özellikler</a> •
  <a href="#nasıl-kullanılır">Nasıl Kullanılır</a> 
</p>

<div align="center">
  <img src="https://github.com/yourusername/wedding_organization/blob/main/public/assets/img/animation.gif" alt="Düğün Organizasyon Sistemi">
</div>



<h2 id="temel-özellikler">Temel Özellikler</h2>

- **Kullanıcı Dostu Arayüz**: Hem müşteriler hem de organizatörler için sezgisel ve kolay kullanılabilir bir arayüz.
- **Randevu Yönetimi**: Kullanıcıların kolayca randevu oluşturmasına, iptal etmesine ve yeniden planlamasına olanak tanır.
- **Gerçek Zamanlı Müsaitlik**: Çift rezervasyonları ve program çakışmalarını önlemek için gerçek zamanlı müsait zaman dilimlerini gösterir.
- **Yönetici Paneli**: Yöneticilere randevular, kullanıcı yönetimi ve diğer ayarlar üzerinde tam kontrol sağlar.

- **Güvenli Giriş Sistemi**: Kullanıcılar güvenli bir şekilde hesap oluşturabilir ve giriş yapabilir.

- **Müşteri Geçmişi**: Müşteriler geçmiş randevularını ve organizasyon geçmişlerini görüntüleyebilir ve yönetebilir.
- **Özelleştirilebilir Ayarlar**: Yöneticiler, sistem ayarlarını düğün salonu veya organizasyon şirketinin ihtiyaçlarına göre yapılandırabilir.


<h2 id="rol-tabanlı-özellikler">Rol Tabanlı Özellikler</h2>

- **Müşteriler**: 
  - Kolayca randevu oluşturabilir, iptal edebilir ve yeniden planlayabilir.
  - Organizasyon geçmişini ve geçmiş randevularını görüntüleyebilir.
  - Paket seçeneklerini inceleyebilir ve özelleştirebilir.

- **Organizatörler**: 
  - Yaklaşan randevuları ve müşteri detaylarını görüntüleyebilir.
  - Müşterilerin özel isteklerini ve tercihlerini görebilir.
  - Mekan, süsleme, menü ve pasta seçeneklerini yönetebilir.

- **Yöneticiler**: 
  - Kullanıcı yönetimine tam erişim (müşteriler, organizatörler ve personel).
  - Randevu ayarları ve müsaitlik üzerinde kontrol.
  - Raporlar oluşturabilir ve sistem kullanımını ve randevuları takip edebilir.
  - Kullanıcılara özel roller ve izinler atayabilir.

<h2 id="nasıl-kullanılır">Nasıl Kullanılır</h2>

Bu Laravel uygulamasını klonlamak ve çalıştırmak için bilgisayarınızda Git ve Composer (PHP bağımlılıkları için) kurulu olması gerekir. Komut satırınızdan:

```bash
# Bu depoyu klonlayın
$ git clone https://github.com/Froxerr/weddingLaravel.git

# Proje dizinine gidin
$ cd weddingLaravel

# PHP bağımlılıklarını yükleyin
$ composer install

# .env dosyasını kopyalayın
$ cp .env.example .env

# Uygulama anahtarını oluşturun
$ php artisan key:generate

# Veritabanını ayarlayın (.env dosyasını veritabanı bilgilerinizle düzenleyin)
# Veritabanı tablolarını oluşturmak için migration'ları çalıştırın
$ php artisan migrate

# Uygulamayı yerel olarak çalıştırın
$ php artisan serve

# Node.js bağımlılıklarını yükleyin
$ npm install

# Frontend varlıklarını derleyin
$ npm run dev
```

> **Not**
> Windows için Linux Bash kullanıyorsanız, [bu kılavuza bakın](https://www.howtogeek.com/261575/how-to-run-graphical-linux-desktop-applications-from-windows-10s-bash-shell/) veya komut isteminden `node` kullanın.


---


> GitHub https://github.com/NURSENAKTAS &nbsp;&middot;&nbsp; <br>
> LinkedIn https://www.linkedin.com/in/nurşen-aktaş-329193303/<br>
> GitHub https://github.com/Froxerr &nbsp;&middot;&nbsp; <br>
> LinkedIn https://www.linkedin.com/in/ibrahim-aral-99804a344/
