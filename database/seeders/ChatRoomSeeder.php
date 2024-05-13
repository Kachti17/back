<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    DB::table('chat_rooms')->insert([
    'name'=>'General'
    ]);
    DB::table('chat_rooms')->insert([
        'name'=>'Call center'
        ]);
     DB::table('chat_rooms')->insert([
            'name'=>'IT department'
            ]);
            DB::table('chat_rooms')->insert([
                'name'=>'Administration'
                ]);
    }
}
