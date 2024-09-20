<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: /visualiza/autentica.php");
    exit();
}

require_once "../config/Database.php";

$db = new Database();

$barbeiro = $_SESSION["user"];

$cortes = $db->select("SELECT * FROM cortes WHERE id_barbeiro = :id_barbeiro", ["id_barbeiro" => $barbeiro->id]);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cortes de <?php echo htmlspecialchars($barbeiro->nome); ?></title>
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
            max-width: 400px;
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

        /* Melhorias para Mobile */
        /* Melhorias para Mobile */
        @media (max-width: 600px) {
            .cortes-table {
                display: none;
                /* Esconder a tabela no mobile */
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

    <h1>Cortes de <?php echo htmlspecialchars($barbeiro->nome); ?></h1>

    <?php if (!$cortes): ?>
        <p class="no-cortes">Nenhum corte cadastrado</p>
    <?php else: ?>
        <?php foreach ($cortes as $corte): ?>
            <div class="corte-bloco">
                <h2>Cliente: <?php echo htmlspecialchars($corte->nome_cliente); ?></h2>
                <p>Data: <?php echo htmlspecialchars(date('d/m/Y', strtotime($corte->data_corte))); ?></p>
                <p>Horário: <?php echo htmlspecialchars($corte->horario); ?></p>
                <button class="delete-btn">Remover</button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>