<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['table_number' => 1,  'section' => 'interior', 'capacity' => 2],
            ['table_number' => 2,  'section' => 'interior', 'capacity' => 2],
            ['table_number' => 3,  'section' => 'interior', 'capacity' => 4],
            ['table_number' => 4,  'section' => 'interior', 'capacity' => 4],
            ['table_number' => 5,  'section' => 'interior', 'capacity' => 4],
            ['table_number' => 6,  'section' => 'interior', 'capacity' => 6],
            ['table_number' => 7,  'section' => 'interior', 'capacity' => 6],
            ['table_number' => 8,  'section' => 'interior', 'capacity' => 2],
            ['table_number' => 9,  'section' => 'interior', 'capacity' => 4],
            ['table_number' => 10, 'section' => 'interior', 'capacity' => 6],
            ['table_number' => 11, 'section' => 'terrace', 'capacity' => 2],
            ['table_number' => 12, 'section' => 'terrace', 'capacity' => 2],
            ['table_number' => 13, 'section' => 'terrace', 'capacity' => 4],
            ['table_number' => 14, 'section' => 'terrace', 'capacity' => 4],
            ['table_number' => 15, 'section' => 'terrace', 'capacity' => 6],
            ['table_number' => 16, 'section' => 'terrace', 'capacity' => 6],
            ['table_number' => 17, 'section' => 'terrace', 'capacity' => 2],
            ['table_number' => 18, 'section' => 'terrace', 'capacity' => 4],
        ];

        DB::table('tables')->insert($tables);
    }
}
