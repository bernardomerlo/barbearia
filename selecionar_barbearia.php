<?php
require_once "config/Database.php";
$db = new Database();

$agendado = $db->selectOne("SELECT * FROM cortes WHERE cliente = :cliente", ["cliente" => $_SERVER["REMOTE_ADDR"]]);

if ($agendado) {
    include "visualiza_agendado.php";
    exit();
}
$barbearias = $db->select("SELECT id, nome, id_endereco FROM barbearias");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Selecione uma Barbearia</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1e1e1e;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        .barbearias-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .barbearia-card {
            background-color: #2e2e2e;
            border-radius: 8px;
            margin: 15px;
            padding: 20px;
            width: 250px;
            text-align: center;
        }

        .barbearia-card h2 {
            margin: 15px 0;
            font-size: 20px;
        }

        .barbearia-card button {
            padding: 10px 15px;
            background-color: #5e5e5e;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .barbearia-card button:hover {
            background-color: #7e7e7e;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>

<body>
    <h1 style="text-align: center;">Selecione uma Barbearia</h1>
    <div class="barbearias-container">
        <?php if ($barbearias): ?>
            <?php foreach ($barbearias as $barbearia): ?>
                <div class="barbearia-card">
                    <h2><?php echo htmlspecialchars($barbearia->nome); ?></h2>
                    <?php
                    $result = $db->selectOne("SELECT bairro, rua, numero FROM enderecos WHERE id = :id", ["id" => $barbearia->id_endereco]);
                    $endereco = $result->bairro . ", " . $result->rua . ", " . $result->numero;
                    ?>
                    <p> <i class="fa-solid fa-location-dot"></i> <?= $endereco ?></p>
                    <form action="index.php" method="get">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($barbearia->id); ?>">
                        <button type="submit">Acessar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma barbearia disponível no momento.</p>
        <?php endif; ?>
    </div>


</body>

</html>