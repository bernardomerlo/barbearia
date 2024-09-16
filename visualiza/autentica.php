<?php
session_start();

require_once "../config/Database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {
        try {
            $db = new Database();
            $user = $db->selectOne("SELECT * FROM barbeiros WHERE nome = :username", [":username" => $username]);

            if ($user && password_verify($password, $user->senha)) {
                $_SESSION["user"] = $user;

                header("Location: /visualiza/index.php");
                exit();
            } else {
                echo "Usuário ou senha inválidos";
            }
        } catch (Exception $e) {
            echo "Erro ao buscar usuário: " . $e->getMessage();
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>

<form method="POST" action="">
    <label for="username">Nome de usuário:</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Senha:</label>
    <input type="password" name="password" id="password" required>

    <button type="submit">Login</button>
</form>