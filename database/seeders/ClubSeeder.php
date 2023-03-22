<?php

namespace Database\Seeders;

use App\Models\Klub;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $temps = [
            ["nama" => "Persib", "kota" => "Bandung"],
            ["nama" => "Persija", "kota" => "Jakarta"],
            ["nama" => "Arema", "kota" => "Malang"],
            // ["nama" => "Persebaya", "kota" => "Surabaya"],
            // ["nama" => "Bali United", "kota" => "Bali"],
        ];

        foreach ($temps as $temp) {
            Klub::create([
                "nama_klub" => $temp["nama"],
                "kota_klub" => $temp["kota"]
            ]);
        }

        var_dump("All Done");
    }
}
