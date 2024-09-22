<?php
session_start();
require_once "../config/Database.php";

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID do barbeiro não fornecido!";
    exit();
}

$id_barbeiro = intval($_GET['id']);

try {
    $db = new Database();
    $barbeiro = $db->selectOne("SELECT * FROM barbeiros WHERE id = :id", ["id" => $id_barbeiro]);

    if (!$barbeiro) {
        echo "Barbeiro não encontrado!";
        exit();
    }

    $cortes = $db->selectOne("SELECT COUNT(*) AS total_cortes FROM cortes WHERE id_barbeiro = :id", ["id" => $id_barbeiro]);
    $total_cortes = $cortes->total_cortes ?? 0;
} catch (Exception $e) {
    echo "Erro ao buscar barbeiro: " . $e->getMessage();
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Detalhes do Barbeiro</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
            justify-content: space-around;
            margin-top: 20px;
        }

        .button-group a {
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            background-color: #5e5e5e;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button-group a:hover {
            background-color: #7e7e7e;
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
        }
    </style>
</head>

<body>
    <div class="logout-btn">
        <a href="gerenciar_barbearia.php">Voltar</a>
    </div>
    <div class="barbeiro-container">
        <h1><?php echo htmlspecialchars($barbeiro->nome); ?></h1>
        <img src="../<?php echo htmlspecialchars($barbeiro->foto); ?>" alt="Foto do Barbeiro">
        <p>Total de Cortes: <?php echo $total_cortes; ?></p>

        <div class="button-group">
            <a href="editar_barbeiro.php?id=<?php echo $id_barbeiro; ?>">Editar</a>

            <a href="remover_barbeiro.php?id=<?php echo $id_barbeiro; ?>" class="delete-btn" onclick="return confirm('Tem certeza que deseja remover este barbeiro? Todos os agendamentos dele serão removidos!')">Remover</a>
        </div>
    </div>

</body>

</html>