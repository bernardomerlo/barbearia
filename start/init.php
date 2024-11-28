<?php

session_start();

include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../config/MongoDb.php';
include_once __DIR__ . '/../config/OracleDb.php';

$db = Database::getInstance();
// $oracle = OracleDb::getInstance();
$mongo = MongoDB::getInstance();
