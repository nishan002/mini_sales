<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Traits\TruncateTable;
use Database\Seeders\Traits\DisableForeignKey;

class CustomerSeeder extends Seeder
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
        $this->truncateTable("customers");
        Customer::factory()
            ->count(10)
            ->create();

        $this->enableForeignKey();
        
    }
}
