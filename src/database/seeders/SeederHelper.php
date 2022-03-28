<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;

class SeederHelper {

  public static function truncate($tables = []): bool
  {
    try {
      if (!is_array($tables)) {
        $tables = [$tables];
      }
      foreach ($tables as $table) {
        Model::unguard();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table($table)->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Model::reguard();
      }
    } catch (\Exception $e) {
      return false;
    }

    return true;
  }

}