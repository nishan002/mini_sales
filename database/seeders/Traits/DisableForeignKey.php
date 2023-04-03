<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait DisableForeignKey
{

    public function disableForeignKey()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    public function enableForeignKey()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
