<?php

namespace models;

class MigrateUp
{
    public function execute()
    {
        $mgrs = array_splice(scandir('./migrations'), 2);

        $mgrs = array_map(function ($v) {
            return str_replace('.php', '', $v);
        }, $mgrs);

        $q = Mysql::$db->query("SELECT name FROM `migrations`");

        $mgrsFromDb = array_column($q->fetchAll(), 'name');

        $notAppliedMigrations = array_diff($mgrs, $mgrsFromDb);

        foreach ($notAppliedMigrations as $mgrs) {

            $class = '\migrations\\' . $mgrs;

            if ((new $class())->up()) {
                $q = Mysql::$db->prepare("INSERT INTO `migrations` (name) VALUES (:migration)");
                $q->execute(['migration' => $mgrs]);
            }
        }
    }
}