<?php

namespace App\Database;

use Illuminate\Database\Query\Processors\MySqlProcessor as BaseMySqlProcessor;

class MySqlProcessor extends BaseMySqlProcessor
{
    /**
     * MySQL 8 returns information_schema columns as COLUMN_NAME; MariaDB / MySQL 5 as column_name.
     * Without this, Schema::hasColumn() fails on MySQL 8 under Laravel 5.1.
     *
     * @param  array  $results
     * @return array
     */
    public function processColumnListing($results)
    {
        return array_map(function ($r) {
            $r = (array) $r;
            return isset($r['column_name']) ? $r['column_name'] : $r['COLUMN_NAME'];
        }, $results);
    }
}
