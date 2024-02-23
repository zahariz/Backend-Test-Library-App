<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'code'=> "M001",
                'name'=> "Angga",
            ],
            [
                'code'=> "M002",
                'name'=> "Ferry",
            ],
            [
                'code'=> "M003",
                'name'=> "Putri",
            ]
        ];

        for($i = 0; $i < count($data); $i++) {
            Member::create($data[$i]);
        }
    }
}
