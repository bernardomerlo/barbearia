<?php

include_once '../start/init.php';

if (!isset($_SESSION["user"])) {
    header("Location: auth/autentica.php");
    exit();
}

$barbeiro = $_SESSION["user"];

// MySQL
/*
$cortes = $db->select("SELECT * FROM cortes WHERE id_barbeiro = :id_barbeiro", ["id_barbeiro" => $barbeiro->id]);
*/

// Oracle
$cortes = //$oracle->select("SELECT * FROM cortes WHERE id_barbeiro = :id_barbeiro", ["id_barbeiro" => $barbeiro->id]);

// MongoDB
/*
$cortes = $mongo->select("cortes", ["id_barbeiro" => $barbeiro->id]);
*/

// Função para remover o corte
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_corte"])) {
    $id_corte = $_POST["id_corte"];

    // MySQL
    /*
    $db->delete("DELETE FROM cortes WHERE id = :id", ["id" => $id_corte]);
    */

    // Oracle
    //$oracle->delete("DELETE FROM cortes WHERE id = :id", ["id" => $id_corte]);

    // MongoDB
    /*
    $mongo->delete("cortes", ["id" => $id_corte]);
    */

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cortes de <?php echo htmlspecialchars($barbeiro->nome); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
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

        .cortes-list {
            width: 100%;
            max-width: 600px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin: 20px 0;
        }

        .corte-bloco {
            background-color: #2e2e2e;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .corte-bloco:hover {
            transform: translateY(-5px);
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.8);
        }

        .corte-bloco h2 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #f0f0f0;
        }

        .corte-bloco p {
            margin: 5px 0;
            font-size: 16px;
        }

        .delete-btn {
            background-color: transparent;
            border: none;
            color: #ff4d4d;
            cursor: pointer;
            font-size: 18px;
            transition: color 0.2s ease;
        }

        .delete-btn:hover {
            color: #ff6666;
        }

        .no-cortes {
            text-align: center;
            font-size: 18px;
            color: #bbb;
            margin-top: 50px;
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
            transition: background-color 0.2s ease;
        }

        .logout-btn a:hover {
            background-color: #ff6666;
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
            transition: background-color 0.2s ease;
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

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                box-shadow: none;
                margin-top: 20px;
            }

            .cortes-list {
                width: 100%;
            }

            .corte-bloco {
                font-size: 16px;
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 20px;
            }

            .logout-btn a {
                padding: 8px 10px;
            }

            .corte-bloco h2 {
                font-size: 18px;
            }

            .corte-bloco p {
                font-size: 14px;
            }

            .delete-btn {
                font-size: 16px;
            }

            .sidebar {
                padding: 10px;
            }

            .sidebar a {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="logout-btn">
        <a href="auth/logout.php">Sair</a>
    </div>

    <h1>Cortes de <?php echo htmlspecialchars($barbeiro->nome); ?></h1>

    <?php if (!$cortes): ?>
        <p class="no-cortes">Nenhum corte cadastrado</p>
    <?php else: ?>
        <div class="cortes-list">
            <?php foreach ($cortes as $corte): ?>
                <div class="corte-bloco">
                    <h2>Cliente: <?php echo htmlspecialchars($corte->nome_cliente); ?></h2>
                    <p>Data: <?php echo htmlspecialchars(date('d/m/Y', strtotime($corte->data_corte))); ?></p>
                    <p>Horário: <?php echo htmlspecialchars($corte->horario); ?></p>

                    <form method="POST" onsubmit="return confirm('Tem certeza que deseja remover este corte?');">
                        <input type="hidden" name="id_corte" value="<?php echo $corte->id; ?>">
                        <button type="submit" class="delete-btn">Remover</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($barbeiro->admin == 1): ?>
        <div class="sidebar">
            <h2>Opções:</h2>
            <a href="gerenciar_barbearia.php" class="gerenciar">Gerenciar Barbearia</a>
        </div>
    <?php endif; ?>

    <!-- Adicionando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>