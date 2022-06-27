<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AkunAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate(); //kosongkan table

        foreach ($this->getData() as $item) {
            $data[] = [
                'name' => $item['name'],
                'password' => $item['password'],
                'role' => $item['role']
            ];
        }

        User::insert($data);
    }

    private function getData()
    {
        return [
            ["name" => "RT001", "password" => bcrypt('rt001rw007'), "role" => "rt"],
            ["name" => "RT002", "password" => bcrypt('rt002rw007'), "role" => "rt"],
            ["name" => "RT003", "password" => bcrypt('rt003rw007'), "role" => "rt"],
            ["name" => "RT004", "password" => bcrypt('rt004rw007'), "role" => "rt"],
            ["name" => "RT005", "password" => bcrypt('rt005rw007'), "role" => "rt"],
            ["name" => "RW007", "password" => bcrypt('adminrw007'), "role" => "rw"]

        ];
    }
}
