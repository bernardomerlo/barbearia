<?php
session_start();
require_once "../config/Database.php";

if (!isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id_barbeiro = intval($_POST['id']);
    $nome = trim($_POST['name']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    try {
        $db = new Database();

        $barbeiro = $db->selectOne("SELECT * FROM barbeiros WHERE id = :id", ["id" => $id_barbeiro]);

        if (!$barbeiro) {
            header("Location: gerenciar_barbearia.php");
            exit();
        }

        $foto = $barbeiro->foto;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
            $foto_nome = $_FILES['photo']['name'];
            $foto_tmp = $_FILES['photo']['tmp_name'];
            $foto_destino_relativo = "imgs/" . basename($foto_nome);
            $foto_destino_absoluto = "../" . $foto_destino_relativo;

            if (move_uploaded_file($foto_tmp, $foto_destino_absoluto)) {
                $foto = $foto_destino_relativo;
            } else {
                $_SESSION['error'] = "Erro ao fazer upload da foto.";
                header("Location: formulario_editar_barbeiro.php?id=$id_barbeiro");
                exit();
            }
        }

        $sql = "UPDATE barbeiros SET nome = :nome, foto = :foto, admin = :admin WHERE id = :id";
        $params = [
            "nome" => $nome,
            "foto" => $foto,
            "admin" => $is_admin,
            "id" => $id_barbeiro
        ];


        $db->update($sql, $params);

        $_SESSION['success'] = "Barbeiro atualizado com sucesso!";
        header("Location: gerenciar_barbearia.php");
        exit();
    } catch (Exception $e) {
        error_log("Erro ao editar barbeiro com ID $id_barbeiro: " . $e->getMessage());
        $_SESSION['error'] = "Erro ao editar barbeiro.";
        header("Location: formulario_editar_barbeiro.php?id=$id_barbeiro");
        exit();
    }
} else {
    header("Location: gerenciar_barbearia.php");
    exit();
}
