<?php
session_start();
require_once "../config/Database.php"; // Ajuste o caminho conforme necessário

// Verifica se o usuário está autenticado
if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

// Verifica se o ID do barbeiro foi passado na URL
if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    header("Location: gerenciar_barbearia.php");
    exit();
}

$id_barbeiro = intval($_GET['id']);

try {
    $db = new Database();
    // Busca o barbeiro pelo ID
    $barbeiro = $db->selectOne("SELECT * FROM barbeiros WHERE id = :id", ["id" => $id_barbeiro]);

    if (!$barbeiro) {
        // Se o barbeiro não for encontrado, redireciona
        header("Location: gerenciar_barbearia.php");
        exit();
    }
} catch (Exception $e) {
    // Log de erro para análise
    error_log("Erro ao buscar barbeiro com ID $id_barbeiro: " . $e->getMessage());
    header("Location: erro.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Barbeiro</title>
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

        .register-form {
            background-color: #2e2e2e;
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
            box-sizing: border-box;
        }

        .register-form h1 {
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
            color: #fff;
        }

        .register-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #fff;
        }

        .register-form input[type="text"],
        .register-form input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #3e3e3e;
            color: #fff;
            font-size: 16px;
        }

        .register-form input[type="text"]:focus,
        .register-form input[type="file"]:focus {
            outline: none;
            border: 1px solid #5e5e5e;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
        }

        .register-form button {
            width: 100%;
            padding: 15px;
            background-color: #5e5e5e;
            border: none;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .register-form button:hover {
            background-color: #7e7e7e;
        }

        .register-form .checkbox-group {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .register-form .checkbox-group label {
            color: #fff;
            margin-left: 10px;
            display: inline-block;
        }

        .register-form .checkbox-group input[type="checkbox"] {
            margin-right: 10px;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px;
            }

            .register-form {
                padding: 15px;
                width: 100%;
            }

            .register-form h1 {
                font-size: 22px;
            }

            .register-form button {
                padding: 12px;
                font-size: 16px;
            }

            .register-form input[type="text"],
            .register-form input[type="file"] {
                padding: 8px;
                font-size: 14px;
            }
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

    <form class="register-form" method="POST" enctype="multipart/form-data" action="editar_barbeiro.php">
        <h1>Editar Barbeiro</h1>

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($barbeiro->id); ?>">

        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($barbeiro->nome); ?>" required>

        <label for="photo">Foto (deixe em branco para manter a atual):</label>
        <input type="file" name="photo" id="photo" accept="image/*">

        <div class="checkbox-group">
            <label for="is_admin">É administrador?</label>
            <input type="checkbox" name="is_admin" id="is_admin" <?php echo ($barbeiro->admin) ? 'checked' : ''; ?>>
        </div>

        <button type="submit">Salvar Alterações</button>
    </form>

</body>

</html>