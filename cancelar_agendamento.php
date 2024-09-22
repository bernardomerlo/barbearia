<?php

include_once "config/Database.php";
$db = new Database();

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    if (!is_numeric($id)) {
        die("ID inválido.");
    }

    $db->delete("DELETE FROM cortes WHERE id = :id", ["id" => $id]);
    header("Location: index.php");
}
