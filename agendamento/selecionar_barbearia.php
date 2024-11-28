<?php

include_once '../start/init.php';

// MySQL
/*
$agendado = $db->selectOne("SELECT * FROM cortes WHERE cliente = :cliente", ["cliente" => $_SERVER["REMOTE_ADDR"]]);
*/

// Oracle
//$agendado = //$oracle->selectOne("SELECT * FROM cortes WHERE cliente = :cliente", ["cliente" => $_SERVER["REMOTE_ADDR"]]);

// MongoDB

$agendado = $mongo->selectOne("cortes", ["cliente" => $_SERVER["REMOTE_ADDR"]]);
if ($agendado) {
    include "visualiza_agendado.php";
    exit();
}
// MySQL
/*
$barbearias = $db->select("SELECT id, nome, id_endereco FROM barbearias");
*/

// Oracle
//$barbearias = //$oracle->select("SELECT id, nome, id_endereco FROM barbearias");

// MongoDB
$barbearias = $mongo->select("barbearias", [], ["projection" => ["id" => 1, "nome" => 1, "id_endereco" => 1]]);
 ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecione uma Barbearia</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../imgs/favicon.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        .barbearias-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .barbearia-card {
            background-color: #2e2e2e;
            border-radius: 8px;
            margin: 15px;
            padding: 20px;
            width: 100%;
            max-width: 250px;
            text-align: center;
        }

        .barbearia-card h2 {
            margin: 15px 0;
            font-size: 20px;
        }

        .barbearia-card button {
            padding: 10px 15px;
            background-color: #5e5e5e;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .barbearia-card button:hover {
            background-color: #7e7e7e;
        }

        .barbeiro-container {
            margin-top: 30px;
            text-align: center;
        }

        .barbeiro-button {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 10px;
            background-color: #ffcc00;
            color: #1e1e1e;
            font-size: 18px;
            text-transform: uppercase;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .barbeiro-button:hover {
            background-color: #e6b800;
            transform: scale(1.05);
        }
    </style>

</head>

<body>
    <div class="container">
        <h1 class="text-center">Selecione uma Barbearia</h1>
        <div class="barbearias-container row justify-content-center">
            <?php if ($barbearias): ?>
                <?php foreach ($barbearias as $barbearia): ?>
                    <div class="barbearia-card col-md-4">
                        <h2><?php echo htmlspecialchars($barbearia->nome); ?></h2>
                        <?php
                        // MySQL e Oracle
                        /*
                        $result = $db->selectOne("SELECT bairro, rua, numero FROM enderecos WHERE id = :id", ["id" => $barbearia->id_endereco]);
                        */

                        //$result = //$oracle->selectOne("SELECT bairro, rua, numero FROM enderecos WHERE id = :id", ["id" => $barbearia->id_endereco]);
var_dump($barbearia);
                        // MongoDB
                        $result = $mongo->selectOne("enderecos", ["_id" => $barbearia->id_endereco ?? null]);
                        
                        $endereco = $result->bairro . ", " . $result->rua . ", " . $result->numero;
                        ?>
                        <p> <i class="fa-solid fa-location-dot"></i> <?= $endereco ?></p>
                        <form action="../index.php" method="get">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($barbearia->_id); ?>">
                            <button type="submit" class="btn btn-primary">Acessar</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Nenhuma barbearia disponível no momento.</p>
            <?php endif; ?>
        </div>

        <div class="barbeiro-container">
            <h3>É Barbeiro?</h3>
            <a href="../admin/index.php" class="barbeiro-button">Clique Aqui!</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>