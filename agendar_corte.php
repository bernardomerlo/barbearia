<?php
header('Content-Type: text/html; charset=utf-8');

require_once "config/Database.php";
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_barbeiro = $_POST["id_barbeiro"];
    $nome_cliente = $_POST["nome_cliente"];
    $telefone_cliente = $_POST["telefone_cliente"];
    $data = $_POST["data"];
    $horario = $_POST["horarios"];
    $cliente_ip = $_SERVER["REMOTE_ADDR"];
    $tipo_corte = $_POST["tipo_corte"];

    try {
        $db->beginTransaction();

        $id = $db->insert(
            "INSERT INTO cortes (nome_cliente, telefone_cliente, data_corte, id_barbeiro, cliente, horario, tipo_corte) 
            VALUES (:nome_cliente, :telefone_cliente, :data, :id_barbeiro, :cliente, :horario, :tipo_corte)",
            [
                "nome_cliente" => $nome_cliente,
                "telefone_cliente" => $telefone_cliente,
                "data" => $data,
                "id_barbeiro" => $id_barbeiro,
                "cliente" => $cliente_ip,
                "horario" => $horario,
                "tipo_corte" => $tipo_corte
            ]
        );
        $agendado = [
            "id_barbeiro" => $id_barbeiro,
            "tipo_corte" => $tipo_corte
        ];
        $db->endTransaction();
        header("Location: visualiza_agendado.php");
        exit();
    } catch (Exception $e) {
        $db->rollBack();
        echo "Erro ao agendar corte: " . $e->getMessage();
    }
}
