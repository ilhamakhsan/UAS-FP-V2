<?php

use Illuminate\Database\Seeder;
use App\Buku;


class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buku = [
            [
                'judulBuku' => "Laskar pelangi",
                'penulis' =>"hanung bramantyo",
                'penerbit' =>"gramedia"
            ]
        ];

        foreach($buku as $b){
            Buku::create($b);
        }
    }
}
