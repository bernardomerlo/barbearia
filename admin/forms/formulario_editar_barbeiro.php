<?php

include_once '../../start/init.php';

if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}
if (!isset($_GET['id']) || intval($_GET['id']) <= 0) {
    header("Location: ../gerenciar_barbearia.php");
    exit();
}

$id_barbeiro = intval($_GET['id']);

try {
    $barbeiro = $db->selectOne("SELECT * FROM barbeiros WHERE id = :id", ["id" => $id_barbeiro]);

    if (!$barbeiro) {
        header("Location: ../gerenciar_barbearia.php");
        exit();
    }
} catch (Exception $e) {
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Barbeiro</title>

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
        }

        .register-form h1 {
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
            color: #fff;
        }

        .register-form .form-control {
            background-color: #3e3e3e;
            color: #fff;
            border: none;
            border-radius: 5px;
        }

        .register-form .form-control:focus {
            background-color: #3e3e3e;
            color: #fff;
            border: 1px solid #5e5e5e;
            box-shadow: none;
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
        }
    </style>
</head>

<body>
    <div class="logout-btn">
        <a href="../gerenciar_barbearia.php" class="btn btn-danger">Voltar</a>
    </div>

    <form class="register-form" method="POST" enctype="multipart/form-data" action="../barbeiro/editar_barbeiro.php">
        <h1>Editar Barbeiro</h1>

        <input type="hidden" name="id" value="<?php echo htmlspecialchars($barbeiro->id); ?>">

        <div class="mb-3">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="name" id="name" value="<?php echo htmlspecialchars($barbeiro->nome); ?>" required>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Foto (deixe em branco para manter a atual):</label>
            <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" name="is_admin" id="is_admin" <?php echo ($barbeiro->admin) ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_admin">É administrador?</label>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>