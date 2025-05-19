<?php

namespace Uzinfocom\Dastyor\Shared\Utils;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TableFinderService {

    public function getMigratedTables(): Collection {
        return DB::table('migrations')
            ->selectRaw("split_part(split_part(migration, '_create_', 2), '_table', 1) AS name, migration")
            ->get();
    }

    public function getSchemas(): Collection {
        try {
            return DB::table('information_schema.schemata')
                ->whereNotIn('schema_name', ['pg_catalog', 'information_schema', 'pg_toast'])
                ->get()
                ->pluck('schema_name');
        } catch (Exception) {
            return new Collection();
        }
    }

    public function getTables(): Collection {
        return DB::table('information_schema.tables')
            ->select(DB::raw("table_schema as schema, table_name as name, table_schema || '.' || table_name as fqn"))
            ->whereNotIn('table_schema', ['pg_catalog', 'information_schema', 'pg_toast'])
            ->orderBy('schema')
            ->get();
    }
}