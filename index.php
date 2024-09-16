<?php
require_once "config/Database.php";
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_barbeiro = $_POST["id_barbeiro"];
    $nome_cliente = $_POST["nome_cliente"];
    $telefone_cliente = $_POST["telefone_cliente"];
    $data = $_POST["data"];
    $cliente = $_SERVER["REMOTE_ADDR"];

    // Inserir os dados no banco (descomentando a linha abaixo quando necessário)
    // $db->insert("INSERT INTO cortes (nome_cliente, telefone_cliente, data_corte, id_barbeiro, cliente) VALUES (:nome_cliente, :telefone_cliente, :data, :id_barbeiro, :cliente)", [
    //     "nome_cliente" => $nome_cliente,
    //     "telefone_cliente" => $telefone_cliente,
    //     "data" => $data,
    //     "id_barbeiro" => $id_barbeiro,
    //     "cliente" => $cliente
    // ]);
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Agendamento</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #4b4b4b;
        }

        form {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .barbeiro-imagem {
            text-align: center;
            margin-bottom: 15px;
        }

        .barbeiro-imagem img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            font-size: 16px;
        }

        select:focus {
            outline: none;
            border-color: #a67c52;
            box-shadow: 0 0 5px rgba(166, 124, 82, 0.5);
        }

        input[type="text"],
        input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 2px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            color: #333;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="date"]:focus {
            outline: none;
            border-color: #a67c52;
            box-shadow: 0 0 5px rgba(166, 124, 82, 0.5);
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #a67c52;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #7a5638;
        }

        h1 {
            color: #a67c52;
            text-align: center;
            font-size: 24px;
        }
    </style>
</head>

<body>

    <form method="POST" action="">
        <h1>Bem-vindo à Barbearia <?= htmlspecialchars($db->selectOne("SELECT nome FROM barbearias WHERE id = :id", ["id" => $_GET["id"]])->nome) ?></h1>
        <h1>Agendar Corte</h1>

        <div class="barbeiro-imagem">
            <img id="barbeiroFoto" src="" alt="Foto do barbeiro">
        </div>

        <label for="id_barbeiro">Barbeiros Disponíveis:</label>
        <select name="id_barbeiro" id="id_barbeiro" required onchange="trocarImagemBarbeiro()">
            <option value="">Selecione um barbeiro</option>
            <?php
            $barbeiros = $db->select("SELECT id, nome, foto FROM barbeiros WHERE id_barbearia = :id", ["id" => $_GET["id"]]);
            foreach ($barbeiros as $barbeiro) {
                echo "<option value='" . htmlspecialchars($barbeiro->id) . "' data-foto='" . htmlspecialchars($barbeiro->foto) . "'>" . htmlspecialchars($barbeiro->nome) . "</option>";
            }
            ?>
        </select>

        <label for="nome_cliente">Nome do cliente:</label>
        <input type="text" name="nome_cliente" id="nome_cliente" required>

        <label for="telefone_cliente">Telefone do cliente:</label>
        <input type="text" name="telefone_cliente" id="telefone_cliente" required>

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" required>

        <button type="submit">Agendar</button>
    </form>

    <script>
        function trocarImagemBarbeiro() {
            // Obter o barbeiro selecionado
            var select = document.getElementById('id_barbeiro');
            var selectedOption = select.options[select.selectedIndex];
            var fotoUrl = selectedOption.getAttribute('data-foto');

            // Atualizar a imagem do barbeiro
            var barbeiroFoto = document.getElementById('barbeiroFoto');
            if (fotoUrl) {
                barbeiroFoto.src = fotoUrl;
            } else {
                barbeiroFoto.src = 'imgs/default_image_barbeiro.png';
            }
        }

        window.onload = function() {
            trocarImagemBarbeiro();
        };
    </script>

</body>

</html>