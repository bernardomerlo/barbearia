<?php
header('Content-Type: text/html; charset=utf-8');

require_once "config/Database.php";
$db = new Database();

if (!isset($_COOKIE['visited'])) {
    include_once "splash_screen.php";
}

if (!isset($_GET["id"])) {
    header("Location: selecionar_barbearia.php");
    exit();
}

$agendado = $db->selectOne("SELECT id FROM cortes WHERE cliente = :cliente", ["cliente" => $_SERVER["REMOTE_ADDR"]]);

if ($agendado) {
    include "visualiza_agendado.php?id=" . $agendado->id;
    exit();
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
            background-color: #1e1e1e;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        form {
            background-color: #2e2e2e;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 600px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #fff;
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

        select,
        input[type="text"],
        input[type="date"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: #3e3e3e;
            color: #fff;
            font-size: 16px;
        }

        select:focus,
        input[type="text"]:focus,
        input[type="date"]:focus {
            outline: none;
            border: 1px solid #5e5e5e;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5e5e5e;
            border: none;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #7e7e7e;
        }

        button[disabled] {
            background-color: #4e4e4e;
            cursor: not-allowed;
        }

        h1 {
            color: #fff;
            text-align: center;
            font-size: 24px;
        }

        .spinner {
            display: none;
            width: 25px;
            height: 25px;
            border: 4px solid #fff;
            border-top: 4px solid #5e5e5e;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-left: auto;
            margin-right: auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <form method="POST" action="agendar_corte.php" id="agendamentoForm">
        <h1>Agendar Corte na Barbearia <?= htmlspecialchars($db->selectOne("SELECT nome FROM barbearias WHERE id = :id", ["id" => $_GET["id"]])->nome) ?></h1>

        <div class="barbeiro-imagem">
            <img id="barbeiroFoto" src="imgs/default_image_barbeiro.png" alt="Foto do barbeiro">
        </div>

        <label for="id_barbeiro">Barbeiros Disponíveis:</label>
        <select name="id_barbeiro" id="id_barbeiro" required>
            <option value="">Selecione um barbeiro</option>
            <?php
            $barbeiros = $db->select("SELECT id, nome, foto FROM barbeiros WHERE id_barbearia = :id", ["id" => $_GET["id"]]);
            foreach ($barbeiros as $barbeiro) {
                echo "<option value='" . htmlspecialchars($barbeiro->id) . "' data-foto='" . htmlspecialchars($barbeiro->foto) . "'>" . htmlspecialchars($barbeiro->nome) . "</option>";
            }
            ?>
        </select>

        <label for="data">Data:</label>
        <input type="date" name="data" id="data" required>

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

        <label for="nome_cliente">Seu nome:</label>
        <input type="text" name="nome_cliente" id="nome_cliente" required>

        <label for="telefone_cliente">Telefone:</label>
        <input type="text" name="telefone_cliente" id="telefone_cliente" required>

        <button type="submit">Agendar</button>
        <div class="spinner" id="spinner"></div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nomeClienteInput = document.getElementById('nome_cliente');
            const telefoneClienteInput = document.getElementById('telefone_cliente');
            const idBarbeiroSelect = document.getElementById('id_barbeiro');
            const dataInput = document.getElementById('data');
            const horariosSelect = document.getElementById('horarios');
            const form = document.getElementById('agendamentoForm');
            const spinner = document.getElementById('spinner');

            if (localStorage.getItem('nome_cliente')) {
                nomeClienteInput.value = localStorage.getItem('nome_cliente');
            }
            if (localStorage.getItem('telefone_cliente')) {
                telefoneClienteInput.value = localStorage.getItem('telefone_cliente');
            }

            nomeClienteInput.addEventListener('input', function() {
                localStorage.setItem('nome_cliente', nomeClienteInput.value);
            });

            telefoneClienteInput.addEventListener('input', function() {
                localStorage.setItem('telefone_cliente', telefoneClienteInput.value);
            });

            idBarbeiroSelect.addEventListener('change', function() {
                const fotoUrl = idBarbeiroSelect.options[idBarbeiroSelect.selectedIndex].getAttribute('data-foto');
                const barbeiroFoto = document.getElementById('barbeiroFoto');
                barbeiroFoto.src = fotoUrl ? fotoUrl : 'imgs/default_image_barbeiro.png';
                atualizarHorarios();
            });

            dataInput.addEventListener('change', atualizarHorarios);

            function atualizarHorarios() {
                const idBarbeiro = idBarbeiroSelect.value;
                const dataAgendamento = dataInput.value;

                if (idBarbeiro && dataAgendamento) {
                    fetch(`buscar_horarios.php?id_barbeiro=${idBarbeiro}&data=${dataAgendamento}`)
                        .then(response => response.json())
                        .then(horarios => {
                            horariosSelect.innerHTML = "<option value=''>Selecione um horário</option>";
                            horarios.forEach(horario => {
                                const option = document.createElement('option');
                                option.value = horario;
                                option.text = horario;
                                horariosSelect.appendChild(option);
                            });
                        });
                }
            }

            telefoneClienteInput.addEventListener('input', function() {
                let x = telefoneClienteInput.value.replace(/\D/g, '');
                telefoneClienteInput.value = x.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            });

            form.addEventListener('submit', function(e) {
                spinner.style.display = 'block';
                form.querySelector('button').disabled = true;
            });
        });
    </script>

</body>

</html>