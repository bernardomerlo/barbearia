<?php

if (!$id_barbearia = $_GET['id']) {
    header('Location: index.php');
    exit();
}

include_once '../config/Database.php';
$db = new Database();

$barbearia = $db->selectOne("SELECT * FROM barbearias WHERE id = :id", ['id' => $id_barbearia]);
$barbeiros = $db->select("SELECT * FROM barbeiros WHERE id_barbearia = :id_barbearia", ['id_barbearia' => $id_barbearia]);

// Contar os cortes de cada barbeiro
foreach ($barbeiros as $barbeiro) {
    $cortes = $db->selectOne("SELECT COUNT(*) as total_cortes FROM cortes WHERE id_barbeiro = :id_barbeiro", ['id_barbeiro' => $barbeiro->id]);
    $barbeiro->total_cortes = $cortes->total_cortes;
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbeiros</title>
    <style>
        /* O CSS que você forneceu vai aqui */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
        }

        .cortes-table {
            width: 100%;
            max-width: 800px;
            border-collapse: collapse;
            margin: 0 auto;
        }

        .cortes-table th,
        .cortes-table td {
            padding: 8px;
            border: 1px solid #333;
            text-align: center;
            font-size: 14px;
        }

        .cortes-table th {
            background-color: #2e2e2e;
        }

        .cortes-table tr:nth-child(even) {
            background-color: #2a2a2a;
        }

        .no-cortes {
            text-align: center;
            font-size: 18px;
            color: #bbb;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .logout-btn a {
            color: #fff;
            text-decoration: none;
            background-color: #ff4d4d;
            padding: 10px 15px;
            border-radius: 5px;
        }

        .delete-btn {
            background-color: transparent;
            border: none;
            color: #ff4d4d;
            cursor: pointer;
            font-size: 18px;
        }

        .altera-btn {
            background-color: transparent;
            border: none;
            color: #f5cb42;
            cursor: pointer;
            font-size: 18px;
        }

        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            height: 100%;
            width: 250px;
            background-color: #2e2e2e;
            padding: 20px;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.5);
        }

        .sidebar h2 {
            color: #fff;
            margin-bottom: 20px;
            font-size: 20px;
        }

        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin-bottom: 10px;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #ff6666;
        }

        .sidebar a.inserir {
            background-color: #04AA6D;
        }

        .sidebar a.inserir:hover {
            background-color: #029b5a;
        }

        .sidebar a.remover {
            background-color: #ff4d4d;
        }

        .sidebar a.remover:hover {
            background-color: #ff6666;
        }

        .sidebar a.gerenciar {
            background-color: #138496;
        }

        .sidebar a.gerenciar:hover {
            background-color: #13708e;
        }

        @media (max-width: 600px) {
            .cortes-table {
                display: none;
            }

            .corte-bloco {
                width: 100%;
                max-width: 600px;
                background-color: #2e2e2e;
                padding: 15px;
                margin-bottom: 15px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                color: #fff;
                font-size: 16px;
            }

            .corte-bloco h2 {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .corte-bloco p {
                margin: 5px 0;
                font-size: 14px;
            }

            .delete-btn {
                background-color: transparent;
                border: none;
                color: #ff4d4d;
                cursor: pointer;
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <div class="logout-btn">
        <a href="logout.php">Sair</a>
    </div>

    <h1>Barbeiros da Barbearia <?= $barbearia->nome ?></h1>

    <?php if (count($barbeiros) > 0): ?>
        <table class="cortes-table">
            <thead>
                <tr>
                    <th>Nome do Barbeiro</th>
                    <th>Cortes Agendados</th>
                    <th>Remover</th>
                    <th>Visualizar Cortes Agendados</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barbeiros as $barbeiro): ?>
                    <tr>
                        <td><?= htmlspecialchars($barbeiro->nome, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= $barbeiro->total_cortes ?></td>
                        <td><button class="delete-btn">X</button></td>
                        <td><button class="altera-btn">X</button></td>
                        <!-- <td><a href="remove_barbeiro?id=<?= $barbeiro->id ?>" class="delete-link">X</a></td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-cortes">Nenhum barbeiro encontrado.</p>
    <?php endif; ?>

</body>

</html>