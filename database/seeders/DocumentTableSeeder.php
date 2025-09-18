<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dms\Document;

class DocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::factory()->count(100)->create();
    }
}
