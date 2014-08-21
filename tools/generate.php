<?php
// Use default autoload implementation
require __DIR__.'/../vendor/mindaphp/Loader.php';
// Load the libraries
require __DIR__.'/../config/loader.php';
// Load the config parameters
require __DIR__.'/../config/config.php';

use MindaPHP\DB;

$entities = DB::select('SELECT `TABLE_NAME` FROM `INFORMATION_SCHEMA`.`TABLES` WHERE `TABLE_SCHEMA` = ?;',DB::$database);
$entities = array_map(function($r){return strtolower(str_replace('_', ' ',$r['TABLES']['TABLE_NAME']));}, $entities);
echo "Entities found: ".implode(', ',$entities)."\n";
$default = $entities[count($entities)-1];
echo "[1/3] Entity name (plural) [$default]";
$plural = strtolower(trim(fgets(STDIN)))?:$default;
$default = rtrim($plural,'s');
echo "[2/3] Entity name (singular) [$default]";
$singular = strtolower(trim(fgets(STDIN)))?:$default;
$table = str_replace(' ', '_',$plural);
$fields = DB::select('SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA` = ? AND `TABLE_NAME` = ?;',DB::$database,$table);
$fields = array_map(function($r){return $r['COLUMNS']['COLUMN_NAME'];}, $fields);
var_dump($fields);