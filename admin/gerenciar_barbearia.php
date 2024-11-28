<?php

include_once '../start/init.php';

if (!$_SESSION["user"]->id_barbearia) {
    header('Location: index.php');
    exit();
}

$id_barbearia = $_SESSION["user"]->id_barbearia;

// MySQL
/*
$barbearia = $db->selectOne("SELECT * FROM barbearias WHERE id = :id", ['id' => $id_barbearia]);
$barbeiros = $db->select("SELECT * FROM barbeiros WHERE id_barbearia = :id_barbearia AND id != :id", ['id_barbearia' => $id_barbearia, 'id' => $_SESSION["user"]->id]);

foreach ($barbeiros as $barbeiro) {
    $cortes = $db->selectOne("SELECT COUNT(*) as total_cortes FROM cortes WHERE id_barbeiro = :id_barbeiro", ['id_barbeiro' => $barbeiro->id]);
    $barbeiro->total_cortes = $cortes->total_cortes;
}
*/

// Oracle
$barbearia = //$oracle->selectOne("SELECT * FROM barbearias WHERE id = :id", ['id' => $id_barbearia]);
$barbeiros = //$oracle->select("SELECT * FROM barbeiros WHERE id_barbearia = :id_barbearia AND id != :id", ['id_barbearia' => $id_barbearia, 'id' => $_SESSION["user"]->id]);

foreach ($barbeiros as $barbeiro) {
    $cortes = //$oracle->selectOne("SELECT COUNT(*) as total_cortes FROM cortes WHERE id_barbeiro = :id_barbeiro", ['id_barbeiro' => $barbeiro->id]);
    $barbeiro->total_cortes = $cortes->total_cortes;
}

// MongoDB
/*
$barbearia = $mongo->selectOne("barbearias", ['id' => $id_barbearia]);
$barbeiros = $mongo->select("barbeiros", ['id_barbearia' => $id_barbearia, 'id' => ['$ne' => $_SESSION["user"]->id]]);

foreach ($barbeiros as &$barbeiro) {
    $barbeiro['total_cortes'] = $mongo->count("cortes", ['id_barbeiro' => $barbeiro['id']]);
}
*/
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbeiros</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="shortcut icon" href="../imgs/favicon.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
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
            font-size: 24px;
        }

        .cortes-table {
            width: 100%;
            max-width: 800px;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .cortes-table th,
        .cortes-table td {
            padding: 12px;
            border: 1px solid #444;
            text-align: center;
            font-size: 16px;
        }

        .cortes-table th {
            background-color: #2e2e2e;
            color: #fff;
            font-weight: 500;
        }

        .cortes-table tr {
            transition: background-color 0.2s;
        }

        .cortes-table tr:hover {
            background-color: #3a3a3a;
        }

        .cortes-table td {
            background-color: #1f1f1f;
        }

        .cortes-table tr:nth-child(even) td {
            background-color: #2a2a2a;
        }

        .table-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            overflow-x: auto;
        }

        .btn-primary {
            background-color: #04AA6D;
            border-color: #04AA6D;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #029b5a;
        }

        .logout-btn {
            width: 100%;
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .logout-btn a {
            color: #fff;
            text-decoration: none;
            background-color: #ff4d4d;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .logout-btn a:hover {
            background-color: #ff6666;
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
        }

        /* Responsividade */
        @media (max-width: 768px) {
            h1 {
                font-size: 22px;
            }

            .btn-primary {
                padding: 8px 16px;
                font-size: 14px;
            }

            .cortes-table th,
            .cortes-table td {
                font-size: 14px;
                padding: 8px;
            }

            .inserir {
                padding: 10px 15px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 20px;
            }

            .btn-primary {
                font-size: 13px;
                padding: 6px 10px;
            }

            .inserir {
                font-size: 12px;
                padding: 8px 10px;
            }

            .table-container {
                overflow-x: scroll;
            }

            .logout-btn {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="logout-btn">
        <a href="index.php">Voltar</a>
    </div>

    <h1>Barbeiros da <?= htmlspecialchars($barbearia->nome) ?></h1>

    <div class="table-container">
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
                            <td>
                                <a href="barbeiro/visualizar_barbeiro.php?id=<?= $barbeiro->id ?>" class="btn btn-info btn-sm">
                                    <i class="fa fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-cortes">Nenhum barbeiro encontrado.</p>
        <?php endif; ?>
    </div>

    <div>
        <a href="forms/formulario_barbeiro.php" class="inserir">Inserir Barbeiro</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>