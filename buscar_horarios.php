<?php
require_once "config/Database.php";
$db = new Database();

if (isset($_GET["id_barbeiro"]) && isset($_GET["data"])) {
    $id_barbeiro = $_GET["id_barbeiro"];
    $data = $_GET["data"];

    $horarios = $db->select(
        "SELECT h.horario 
        FROM horarios h 
        LEFT JOIN cortes c 
        ON h.horario = c.horario 
        AND c.data_corte = :data 
        AND c.id_barbeiro = :id_barbeiro 
        WHERE h.horario BETWEEN '09:00' AND '19:00' 
        AND c.horario IS NULL",
        ["id_barbeiro" => $id_barbeiro, "data" => $data]
    );

    $horariosDisponiveis = [];
    foreach ($horarios as $horario) {
        $horariosDisponiveis[] = $horario->horario;
    }

    echo json_encode($horariosDisponiveis);
}
