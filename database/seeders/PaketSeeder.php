<?php

namespace Database\Seeders;

use App\Models\Paketler;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonData = $this->getDecode("paket"); //json formatından çöz ve jsonData adlı değişkene verileri at
        foreach ($jsonData as $data)
        {
            Paketler::create([
                'id' => $data->id,
                'mekan_id' => $data->mekan_id,
                'susleme_id' => $data->susleme_id,
                'menu_ogeleri_id' => $data->menu_ogeleri_id,
                'pasta_id' => $data->pasta_id,
                'organizasyon_id' => $data->organizasyon_id,
                'paket_adi' => $data->paket_adi,
                'temel_fiyat' => $data->temel_fiyat,
                'ekstra_fiyat' => $data->ekstra_fiyat,
                'olusturulma_tarihi' => $data->olusturulma_tarihi,
                'guncellenme_tarihi' => $data->guncelleme_tarihi
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
