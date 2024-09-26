<?php

include_once '../start/init.php';

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $corte_agendado = $db->selectOne("SELECT * FROM cortes WHERE id = :id", ["id" => $id]);
} else {
    $cliente = $_SERVER["REMOTE_ADDR"];
    $corte_agendado = $db->selectOne("SELECT * FROM cortes WHERE cliente = :cliente", ["cliente" => $cliente]);
}

$barbeiro = $db->selectOne("SELECT * FROM barbeiros WHERE id = :id", ["id" => $corte_agendado->id_barbeiro]);
$tipo_corte = $db->selectOne("SELECT * FROM tipos_cortes WHERE id = :id", ["id" => $corte_agendado->tipo_corte]);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento Atual</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../imgs/favicon.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1e1e1e;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #2e2e2e;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            color: #fff;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            color: #fff;
        }

        p {
            margin: 15px 0;
            font-size: 18px;
        }

        .details {
            margin-bottom: 20px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5e5e5e;
            border: none;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #7e7e7e;
        }

        .center {
            text-align: center;
        }

        .barbeiro-imagem {
            text-align: center;
            margin-bottom: 15px;
        }

        .barbeiro-imagem img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Seu Próximo Corte!</h1>

        <div class="barbeiro-imagem">
            <img src="/barbearia/<?= $barbeiro->foto ?>" alt="Foto do barbeiro">
        </div>

        <div class="details">
            <p><strong>Barbeiro:</strong> <?= htmlspecialchars($barbeiro->nome) ?></p>
            <p><strong>Data:</strong> <?= date("d/m/Y", strtotime($corte_agendado->data_corte)) ?> às <?= htmlspecialchars($corte_agendado->horario) ?></p>
            <p><strong>Corte:</strong> <?= htmlspecialchars($tipo_corte->nome) ?></p>
        </div>

        <div class="center">
            <button onclick="confirmarCancelamento('<?= htmlspecialchars($corte_agendado->id) ?>')">Cancelar Agendamento</button>
        </div>

        <script>
            function confirmarCancelamento(id) {
                if (confirm("Tem certeza que deseja cancelar este agendamento?")) {
                    window.location.href = 'cancelar_agendamento.php?id=' + id;
                }
            }
        </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>