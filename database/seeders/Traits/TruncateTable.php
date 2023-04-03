<?php

namespace Database\Seeders\Traits;
trait TruncateTable
{

    public function truncateTable(string $table)
    {
        \Illuminate\Support\Facades\DB::table($table)->truncate();
    }
}
