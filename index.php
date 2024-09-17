<?php
require_once "config/Database.php";
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_barbeiro = $_POST["id_barbeiro"];
    $nome_cliente = $_POST["nome_cliente"];
    $telefone_cliente = $_POST["telefone_cliente"];
    $data = $_POST["data"];
    $horario = $_POST["horarios"];
    $cliente_ip = $_SERVER["REMOTE_ADDR"];
    $tipo_corte = $_POST["tipo_corte"];

    try {
        $db->beginTransaction();

        $db->insert(
            "INSERT INTO cortes (nome_cliente, telefone_cliente, data_corte, id_barbeiro, cliente, horario, tipo_corte) 
            VALUES (:nome_cliente, :telefone_cliente, :data, :id_barbeiro, :cliente, :horario, :tipo_corte)",
            [
                "nome_cliente" => $nome_cliente,
                "telefone_cliente" => $telefone_cliente,
                "data" => $data,
                "id_barbeiro" => $id_barbeiro,
                "cliente" => $cliente_ip,
                "horario" => $horario,
                "tipo_corte" => $tipo_corte
            ]
        );
        $db->endTransaction();
    } catch (Exception $e) {
        $db->rollBack();
        echo "Erro ao agendar corte: " . $e->getMessage();
    }
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
        <select name="id_barbeiro" id="id_barbeiro" required onchange="atualizarHorarios()">
            <option value="">Selecione um barbeiro</option>
            <?php
            $barbeiros = $db->select("SELECT id, nome, foto FROM barbeiros WHERE id_barbearia = :id", ["id" => $_GET["id"]]);
            foreach ($barbeiros as $barbeiro) {
                echo "<option value='" . htmlspecialchars($barbeiro->id) . "' data-foto='" . htmlspecialchars($barbeiro->foto) . "'>" . htmlspecialchars($barbeiro->nome) . "</option>";
            }
            ?>
        </select>

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" required onchange="atualizarHorarios()">

        <label for="horarios">Horários Disponíveis</label>
        <select name="horarios" id="horarios" required>
            <option value="">Selecione um horário</option>
        </select>

        <label for="tipo_corte">Corte</label>
        <select name="tipo_corte" id="tipo_corte" required>
            <?php
            $tipos_corte = $db->select("SELECT id, nome FROM tipos_cortes");
            foreach ($tipos_corte as $tipo_corte) {
                echo "<option value='" . htmlspecialchars($tipo_corte->id) . "'>" . htmlspecialchars($tipo_corte->nome) . "</option>";
            }
            ?>
        </select>

        <label for="nome_cliente">Nome do cliente:</label>
        <input type="text" name="nome_cliente" id="nome_cliente" required>

        <label for="telefone_cliente">Telefone do cliente:</label>
        <input type="text" name="telefone_cliente" id="telefone_cliente" required>

        <button type="submit">Agendar</button>
    </form>

    <script>
        function atualizarHorarios() {
            var idBarbeiro = document.getElementById('id_barbeiro').value;
            var dataAgendamento = document.getElementById('data').value;

            if (idBarbeiro && dataAgendamento) {
                // Faz uma requisição AJAX para buscar os horários disponíveis
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "buscar_horarios.php?id_barbeiro=" + idBarbeiro + "&data=" + dataAgendamento, true);
                xhr.onload = function() {
                    if (this.status == 200) {
                        var horarios = JSON.parse(this.responseText);
                        var horariosSelect = document.getElementById('horarios');
                        horariosSelect.innerHTML = "<option value=''>Selecione um horário</option>"; // Limpa os horários antigos

                        horarios.forEach(function(horario) {
                            var option = document.createElement('option');
                            option.value = horario;
                            option.text = horario;
                            horariosSelect.appendChild(option);
                        });
                    }
                };
                xhr.send();
            }
        }

        function trocarImagemBarbeiro() {
            var select = document.getElementById('id_barbeiro');
            var selectedOption = select.options[select.selectedIndex];
            var fotoUrl = selectedOption.getAttribute('data-foto');

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