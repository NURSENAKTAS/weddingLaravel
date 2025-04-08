<?php

namespace Database\Seeders;

use App\Models\Iletisim;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IletisimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("iletisim"); //json formatından çöz ve jsonData adlı değişkene verileri at
        foreach ($jsonData as $data)
        {
            Iletisim::create([
                'kullanici_id' => $data->kullanici_id,
                'ad_soyad' => $data->ad_soyad,
                'email' => $data->email,
                'konu' => $data->konu,
                'mesaj' => $data->mesaj,
                'durum' => $data->durum,
                'olusturulma_tarihi' => $data->olusturulma_tarihi
            ]);
        }
    }

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
