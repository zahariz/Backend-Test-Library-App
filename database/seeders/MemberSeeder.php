<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        for($i = 0; $i < 5; $i++){
            Member::create([
                'name' => 'Test'.$i,
                'code' => 'M001',
                'is_penalized' => false,
            ]);
        }


    }
}
