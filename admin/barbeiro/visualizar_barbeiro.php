<?php

include_once '../../start/init.php';

if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID do barbeiro não fornecido!";
    exit();
}

$id_barbeiro = intval($_GET['id']);

try {
    // MySQL
    /*
    $barbeiro = $db->selectOne("SELECT * FROM barbeiros WHERE id = :id", ["id" => $id_barbeiro]);

    if (!$barbeiro) {
        echo "Barbeiro não encontrado!";
        exit();
    }

    $cortes = $db->selectOne("SELECT COUNT(*) AS total_cortes FROM cortes WHERE id_barbeiro = :id", ["id" => $id_barbeiro]);
    $total_cortes = $cortes->total_cortes ?? 0;
    */

    // Oracle
    $barbeiro = //$oracle->selectOne("SELECT * FROM barbeiros WHERE id = :id", ["id" => $id_barbeiro]);

    if (!$barbeiro) {
        echo "Barbeiro não encontrado!";
        exit();
    }

    $cortes = //$oracle->selectOne("SELECT COUNT(*) AS total_cortes FROM cortes WHERE id_barbeiro = :id", ["id" => $id_barbeiro]);
    $total_cortes = $cortes->total_cortes ?? 0;

    // MongoDB
    /*
    $barbeiro = $mongo->selectOne("barbeiros", ["id" => $id_barbeiro]);

    if (!$barbeiro) {
        echo "Barbeiro não encontrado!";
        exit();
    }

    $total_cortes = $mongo->count("cortes", ["id_barbeiro" => $id_barbeiro]);
    */
} catch (Exception $e) {
    echo "Erro ao buscar barbeiro: " . $e->getMessage();
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Barbeiro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../../imgs/favicon.png" type="image/x-icon">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 10px;
            box-sizing: border-box;
        }

        .barbeiro-container {
            background-color: #2e2e2e;
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .barbeiro-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
        }

        .barbeiro-container img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .barbeiro-container p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button-group a {
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #FFA500;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button-group a:hover {
            background-color: #e69500;
        }

        .button-group .delete-btn {
            background-color: #ff4d4d;
        }

        .button-group .delete-btn:hover {
            background-color: #ff2d2d;
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
            transition: background-color 0.3s ease;
        }

        .logout-btn a:hover {
            background-color: #ff6666;
        }
    </style>
</head>

<body>
    <div class="logout-btn">
        <a href="../gerenciar_barbearia.php" class="btn btn-danger">Voltar</a>
    </div>

    <div class="barbeiro-container">
        <h1><?php echo htmlspecialchars($barbeiro->nome); ?></h1>
        <img src="../../<?php echo htmlspecialchars($barbeiro->foto); ?>" alt="Foto do Barbeiro" class="img-fluid rounded-circle">
        <p>Total de Cortes: <?php echo $total_cortes; ?></p>

        <div class="button-group">
            <a href="../forms/formulario_editar_barbeiro.php?id=<?php echo $id_barbeiro; ?>" class="btn btn-warning">Editar</a>
            <a href="remover_barbeiro.php?id=<?php echo $id_barbeiro; ?>" class="btn btn-danger delete-btn" onclick="return confirm('Tem certeza que deseja remover este barbeiro? Todos os agendamentos dele serão removidos!')">Remover</a>
        </div>
    </div>

    <!-- Adicionando Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>