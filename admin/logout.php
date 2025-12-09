<?php
session_start();
session_unset();
session_destroy();

// Redireciona para a página inicial (não para login admin)
header("Location: ../index.php");
exit;