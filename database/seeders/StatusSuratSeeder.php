<?php

namespace Database\Seeders;

use App\Models\StatusSurat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StatusSurat::truncate(); //kosongkan table

        foreach ($this->getData() as $item) {
            $data[] = [
                'status' => $item['status']
            ];
        }

        StatusSurat::insert($data);
    }

    private function getData()
    {
        return [
            ["status" => "Sedang Diproses"],
            ["status" => "Telah disetujui oleh Ketua RT"],
            ["status" => "Telah disetujui oleh Ketua RW"],
            ["status" => "Ditolak oleh Ketua RT"],
            ["status" => "Ditolak oleh Ketua RW"],
        ];
    }
}
