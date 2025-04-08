<?php

namespace Database\Seeders;

use App\Models\Odemeler;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OdemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("odeme"); //json formatından çöz ve jsonData adlı değişkene verileri at
        foreach ($jsonData as $data)
        {
            Odemeler::create([
                'id' => $data->id,
                'rezervasyon_id' => $data->rezervasyon_id,
                'tutar' => $data->tutar,
                'odeme_tarihi' => $data->odeme_tarihi,
                'odeme_yontemi' => $data->odeme_yontemi,
                'odeme_durumu' => $data->odeme_durumu,
                'olusturulma_tarihi' => $data->olusturulma_tarihi,
                'guncelleme_tarihi' => $data->guncelleme_tarihi
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
