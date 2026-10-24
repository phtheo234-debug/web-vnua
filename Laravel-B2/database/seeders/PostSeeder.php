<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        DB::table('post')->insert([
            // 'id'=>1,
            'title'=>"Bai viet so 1",
            'slug'=>"bai-viet-so-1",
            'description'=>"Hương dan seeder trong lop",
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
    }
}
