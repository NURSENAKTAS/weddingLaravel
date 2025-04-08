<?php

namespace Database\Seeders;

use App\Models\Pastalar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PastaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("pasta"); //json formatından çöz ve jsonData adlı değişkene verileri at
        foreach ($jsonData as $data)
        {
            Pastalar::create([
                'id' => $data->id,
                'pasta_adi' => $data->pasta_adi,
                'aciklama' => $data->aciklama,
                'fiyat' => $data->fiyat,
                'resim_url' => $data->resim_url,
                'olusturulma_tarihi' => $data->olusturulma_tarihi,
                'gunceleme_tarihi' => $data->guncelleme_tarihi
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
