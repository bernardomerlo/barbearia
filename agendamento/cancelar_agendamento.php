<?php

include_once '../start/init.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    if (!is_numeric($id)) {
        die("ID inválido.");
    }

    // MySQL
    /*
    $db->delete("DELETE FROM cortes WHERE id = :id", ["id" => $id]);
    */

    // Oracle
    $oracle->delete("DELETE FROM cortes WHERE id = :id", ["id" => $id]);

    // MongoDB
    /*
    $mongo->delete("cortes", ["id" => (int)$id]);
    */
    header("Location: ../index.php");
}
