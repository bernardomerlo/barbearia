<?php
require_once "config/Database.php";
$db = new Database();

function countRows($db, $tableName)
{
    return $db->selectOne("SELECT COUNT(*) AS total FROM $tableName")->total;
}

if (!isset($_COOKIE['visited'])) {
    $tabelas = $db->select("SHOW TABLES");

    $tableData = [];

    foreach ($tabelas as $tabela) {
        $tableName = $tabela->{"Tables_in_barbearia"};
        $tableData[$tableName] = countRows($db, $tableName);
    }

    setcookie('visited', 'true', time() + 86400 * 30, '/');
?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Splash Screen</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #1e1e1e;
                color: #fff;
                margin: 0;
                padding: 20px;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .splash-container {
                text-align: center;
                max-width: 800px;
                padding: 40px;
                background-color: #2e2e2e;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
            }

            h1,
            h2,
            p {
                margin-bottom: 15px;
            }

            ul {
                list-style: none;
                padding: 0;
                text-align: center;
                font-size: 20px;
            }

            ul li {
                margin-bottom: 15px;
            }

            ul li span {
                font-weight: bold;
            }

            .footer {
                margin-top: 30px;
                font-size: 14px;
                color: #ccc;
            }

            .loading {
                font-size: 22px;
                margin-top: 20px;
                animation: blink 1.5s infinite;
            }

            @keyframes blink {
                0% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }

                100% {
                    opacity: 1;
                }
            }
        </style>
    </head>

    <body>
        <div class="splash-container">
            <h1>Sistema de Agendamento de Cortes</h1>
            <h2>Total de registros Existentes</h2>
            <ul>
                <?php foreach ($tableData as $tableName => $rowCount): ?>
                    <li><span><?php echo htmlspecialchars($tableName); ?>:</span> <?php echo htmlspecialchars($rowCount); ?> linhas</li>
                <?php endforeach; ?>
            </ul>

            <div class="footer">
                <p><strong>Criadores</strong>: Bernardo Antonio Merlo Soares, Kaio Barbosa Linhares,</p>
                <p>Rikelme Mindelo Biague e Bruno Emanuel</p>
                <p><strong>Disciplina</strong>: Banco de Dados 2024/2</p>
                <p><strong>Professor</strong>: Howarda Roatti</p>
            </div>

            <p class="loading">Carregando o sistema...</p>
        </div>

        <script>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 10000);
        </script>
    </body>

    </html>


<?php
    exit();
}
