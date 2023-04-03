<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Traits\DisableForeignKey;
use Database\Seeders\Traits\TruncateTable;

class ProductSeeder extends Seeder
{

    use TruncateTable, DisableForeignKey;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //
        $this->disableForeignKey();
        $this->truncateTable("products");
         Product::factory()
             ->count(10)
             ->create();

        $this->enableForeignKey();
    }
}
