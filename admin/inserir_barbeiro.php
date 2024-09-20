<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../config/Database.php";

    $nome = $_POST["nome"];
    $senha = $_POST["senha"];
    $barbearia = $_GET["id"];

    $db = new Database();
    $db->insert(
        "INSERT INTO barbeiros (nome, senha, id_barbearia) VALUES (:nome, :senha, :barbearia)",
        ["nome" => $nome, "senha" => password_hash($senha, PASSWORD_DEFAULT), "barbearia" => $barbearia]
    );
}
?>
<form method="POST" action="">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome">
    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha">
    <button type="submit">Inserir</button>
</form>