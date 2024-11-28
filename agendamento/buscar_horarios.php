<?php

include_once '../start/init.php';

if (isset($_GET["id_barbeiro"]) && isset($_GET["data"])) {
    $id_barbeiro = $_GET["id_barbeiro"];
    $data = $_GET["data"];

    // MySQL
    /*
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
    */
    echo $id_barbeiro;
    echo $data;


    // Oracle
    $horarios = //$oracle->select(
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

    // MongoDB
    /*
    $ocupados = $mongo->select("cortes", [
        "id_barbeiro" => $id_barbeiro,
        "data_corte" => $data
    ], ["projection" => ["horario" => 1]]);

    $ocupadosHorarios = array_map(fn($c) => $c['horario'], $ocupados);

    $todosHorarios = $mongo->select("horarios", [
        "horario" => ['$gte' => "09:00", '$lte' => "19:00"]
    ]);

    $horarios = array_filter($todosHorarios, fn($h) => !in_array($h['horario'], $ocupadosHorarios));
    */

    $horariosDisponiveis = [];
    foreach ($horarios as $horario) {
        // Certificar-se de que o campo 'horario' está presente
        if (isset($horario->horario)) {
            $horariosDisponiveis[] = $horario->horario;
        }
    }

    echo json_encode($horariosDisponiveis);
}
