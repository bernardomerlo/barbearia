<?php
session_start();

if (!$_SESSION["user"]->id_barbearia) {
    header('Location: index.php');
    exit();
}

$id_barbearia = $_SESSION["user"]->id_barbearia;

include_once '../config/Database.php';
$db = new Database();

$barbearia = $db->selectOne("SELECT * FROM barbearias WHERE id = :id", ['id' => $id_barbearia]);
$barbeiros = $db->select("SELECT * FROM barbeiros WHERE id_barbearia = :id_barbearia", ['id_barbearia' => $id_barbearia]);

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

        .delete-btn a {
            color: #fff;
            text-decoration: none;
            background-color: #007BFF;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .delete-btn a:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: transparent;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            margin: 0;
        }

        .inserir {
            display: inline-block;
            background-color: #04AA6D;
            color: #fff;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-top: 30px;
        }

        .inserir:hover {
            background-color: #029b5a;
            transform: translateY(-3px);
            box-shadow: 0px 8px 10px rgba(0, 0, 0, 0.15);
        }

        .inserir:active {
            transform: translateY(0);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="logout-btn">
        <a href="index.php">Voltar</a>
    </div>

    <h1>Barbeiros da <?= $barbearia->nome ?></h1>

    <?php if (count($barbeiros) > 0): ?>
        <table class="cortes-table">
            <thead>
                <tr>
                    <th>Nome do Barbeiro</th>
                    <th>Cortes Agendados</th>
                    <th>Visualizar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barbeiros as $barbeiro): ?>
                    <tr>
                        <td><?= htmlspecialchars($barbeiro->nome, ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= $barbeiro->total_cortes ?></td>
                        <td><button class="delete-btn"><a href="barbeiro/visualizar_barbeiro.php?id=<?= $barbeiro->id ?>"><i class="fa-solid fa-eye"></i></a></button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-cortes">Nenhum barbeiro encontrado.</p>
    <?php endif; ?>


    <div>
        <a href="forms/formulario_barbeiro.php" class="inserir">Inserir Barbeiro</a>
    </div>


</body>

</html>