<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../config/Database.php";

    $nome = $_POST["nome"];
    $senha = $_POST["senha"];

    $db = new Database();
    $db->insert("INSERT INTO barbeiros (nome, senha) VALUES (:nome, :senha)", [":nome" => $nome, ":senha" => password_hash($senha, PASSWORD_DEFAULT)]);
}
?>
<form method="POST" action="">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome">
    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha">
    <button type="submit">Inserir</button>
</form>