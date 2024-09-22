<?php
session_start();

require_once "../../config/Database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {
        try {
            $db = new Database();
            $user = $db->selectOne("SELECT * FROM barbeiros WHERE nome = :username", ["username" => $username]);

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
    <title>Login</title>
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

        .login-form {
            background-color: #2e2e2e;
            padding: 40px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        .login-form h1 {
            margin-bottom: 30px;
            text-align: center;
            font-size: 24px;
            color: #fff;
        }

        .login-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #fff;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #3e3e3e;
            color: #fff;
            font-size: 16px;
        }

        .login-form input[type="text"]:focus,
        .login-form input[type="password"]:focus {
            outline: none;
            border: 1px solid #5e5e5e;
            box-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
        }

        .login-form button {
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

        .login-form button:hover {
            background-color: #7e7e7e;
        }

        .login-form .error {
            color: #ff6b6b;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px;
            }

            .login-form {
                padding: 15px;
                width: 100%;
            }

            .login-form h1 {
                font-size: 22px;
            }

            .login-form button {
                padding: 12px;
                font-size: 16px;
            }

            .login-form input[type="text"],
            .login-form input[type="password"] {
                padding: 8px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <form class="login-form" method="POST" action="">
        <h1>Login</h1>

        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <label for="username">Nome de usuário:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Entrar</button>
    </form>

</body>

</html>