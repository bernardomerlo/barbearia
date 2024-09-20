<?php
session_start();
session_unset(); // Limpa todas as variáveis de sessão
session_destroy(); // Destroi a sessão atual
header("Location: index.php"); // Redireciona para a página de login
exit();
