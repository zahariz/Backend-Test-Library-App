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
        $user = User::create([
            'name' => 'Test',
            'email' => 'test@mail.com',
            'password' => bcrypt('rahasia'),
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'code' => 'M001',
            'is_penalized' => false,
        ]);
    }
}
