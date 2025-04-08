<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("user"); //json formatından çöz ve jsonData adlı değişkene verileri at
        //jsonData içerisinde {{"ad":"İbrahim","soyad":"Aral"}, {"ad":"Nurşen", "soyad":"Aktaş"} } tarzında veri tutuyor
        //bu tutulan değer bir dizi olduğu için teker teker foreach ile döndürüyoruz
        foreach ($jsonData as $data)
        {
            User::create([ //benim city'de sadece şehir ismi ve sehir_id varmış
                //sehir_id otomatik arttığı için buraya yazmadım ama yazadabilirim.
                //buraya yazacağım tüm verilerin hepsi json'dan geliyor bu yüzden json'a gireceğin ilk değer
                //yukarıdaki örnekten ad,soyad değerleri veritabanınla aynı olması gerekiyor ki eklesin
                'id' => $data->id, //burada da ekleme işlemi yapıyor
                'name' => $data->name, //burada da ekleme işlemi yapıyor
                'phone' => $data->phone, //burada da ekleme işlemi yapıyor
                'role' => $data->role, //burada da ekleme işlemi yapıyor
                'email' => $data->email, //burada da ekleme işlemi yapıyor
                'email_verified_at' => $data->email_verified_at, //burada da ekleme işlemi yapıyor
                'password' => $data->password, //burada da ekleme işlemi yapıyor
                'remember_token' => $data->remember_token, //burada da ekleme işlemi yapıyor
                'created_at' => $data->created_at, //burada da ekleme işlemi yapıyor
                'updated_at' => $data->updated_at //burada da ekleme işlemi yapıyor
            ]);
        }
    }
    //: array php de methotun döneceği türü söylüyor biz java da hani
    // public void deneme()
    // public int deneme()
    // işte buradaki void ve int döndürme tipini phpde de : array olarak veriyoruz
    public function getDecode(string $rote): array
    {
        $jsonPath = storage_path('app/private/Seeders/'.$rote.'.json');
        $prioritiesJson = file_get_contents($jsonPath);
        // JSON verisini çözümleyin, diziler olarak almak için ikinci parametreyi true yapın
        $decodedData = json_decode($prioritiesJson);

        // JSON hatasını kontrol et
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON çözümleme hatası: ' . json_last_error_msg());
        }

        return $decodedData;
    }
}
