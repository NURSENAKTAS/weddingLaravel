<?php

namespace Database\Seeders;

use App\Models\Randevu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RandevuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("randevu"); //json formatından çöz ve jsonData adlı değişkene verileri at
        foreach ($jsonData as $data)
        {
            Randevu::create([
                'id' => $data->id,
                'kullanici_id' => $data->kullanici_id,
                'paket_id' => $data->paket_id,
                'randevu_tarihi' => $data->randevu_tarihi,
                'randevu_türü' => $data->randevu_türü,
                'ozel_istekler' => $data->ozel_istekler,
                'olusturulma_tarihi' => $data->olusturulma_tarihi,
                'guncelleme_tarihi' => $data->guncelleme_tarihi,
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
