<?php

include_once '../../start/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {
        try {
            // MySQL
            /*
            $user = $db->selectOne("SELECT * FROM barbeiros WHERE nome = :username", ["username" => $username]);
            */

            // Oracle
            $user = //$oracle->selectOne("SELECT * FROM barbeiros WHERE nome = :username", ["username" => $username]);

            // MongoDB
            /*
            $user = $mongo->selectOne("barbeiros", ["nome" => $username]);
            */

            if ($user && password_verify($password, $user->senha)) {
                $_SESSION["user"] = $user;
                header("Location: ../index.php");
                exit();
            } else {
                $error = "Usuário ou senha inválidos";
            }
        } catch (Exception $e) {
            $error = "Erro ao buscar usuário: " . $e->getMessage();
        }
    } else {
        $error = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-form {
            background-color: #2e2e2e;
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            max-width: 500px;
            min-width: 320px;
            box-sizing: border-box;
        }

        .login-form h1 {
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
            color: #fff;
        }

        .login-form .error {
            color: #ff6b6b;
            margin-bottom: 20px;
            text-align: center;
        }

        .container,
        .row {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 d-flex justify-content-center">
                <form class="login-form" method="POST" action="">
                    <h1>Login</h1>

                    <?php if (isset($error)): ?>
                        <div class="error"><?php echo htmlspecialchars($error); ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Nome de usuário:</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>