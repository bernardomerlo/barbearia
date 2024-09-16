<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: /visualiza/autentica.php");
    exit();
}

require_once "../config/Database.php";

$db = new Database();

$barbeiro = $_SESSION["user"];
var_dump($barbeiro);

$cortes = $db->select("SELECT * FROM cortes WHERE id_barbeiro = :id_barbeiro", ["id_barbeiro" => $barbeiro->id]);
if(!$cortes) {
    echo "Nenhum corte cadastrado";
    exit();
}
echo "<h1>Cortes de {$barbeiro->nome}</h1>";

foreach ($cortes as $corte) {
    echo "<p>{$corte->nome}</p>";
}