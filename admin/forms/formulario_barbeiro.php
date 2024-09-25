<?php

include_once '../../start/init.php';

if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

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

        .register-form .error {
            color: #ff6b6b;
            margin-bottom: 20px;
            text-align: center;
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

    <script>
        function validarFormulario(event) {
            var senha = document.getElementById("password").value;
            var confirmSenha = document.getElementById("confirm_password").value;

            if (senha !== confirmSenha) {
                event.preventDefault();
                alert("As senhas não coincidem. Por favor, tente novamente.");
            }
        }

        window.onload = function() {
            var form = document.querySelector(".register-form");
            form.addEventListener("submit", validarFormulario);
        };
    </script>
</head>

<body>
    <div class="logout-btn">
        <a href="../gerenciar_barbearia.php" class="btn btn-danger">Voltar</a>
    </div>

    <form class="register-form" method="POST" enctype="multipart/form-data" action="../barbeiro/inserir_barbeiro.php">
        <h1>Inserir novo Barbeiro</h1>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Repita a senha:</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
        </div>

        <div class="mb-3">
            <label for="photo" class="form-label">Foto:</label>
            <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="is_admin" id="is_admin">
            <label class="form-check-label" for="is_admin">É administrador?</label>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>