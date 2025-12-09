<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: ../login.php?erro=2");
    exit;
}

include_once "../class/CandidaturaDAO.php";
include_once "../class/VagaDAO.php";

$idUsuario = (int)$_SESSION["id"];
$candDAO = new CandidaturaDAO();
$vagaDAO = new VagaDAO();

// Busca candidaturas do usuário
$candidaturas = $candDAO->listarPorUsuario($idUsuario);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Candidaturas - VagasJob</title>
    <link rel="stylesheet" href="../assets/style_new.css">
</head>
<body>
    <!-- HEADER FIXO -->
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <h2>🎯 VagasJob</h2>
            </div>
            
            <nav class="nav-buttons">
                <span class="user-welcome">Olá, <?= htmlspecialchars($_SESSION["nome"]) ?>!</span>
                <a href="../index.php" class="btn btn-outline">Ver Vagas</a>
                <a href="minhas_candidaturas.php" class="btn btn-primary">Minhas Candidaturas</a>
                <a href="../site/logout.php" class="btn btn-danger">Sair</a>
            </nav>
        </div>
    </header>

    <section class="vagas-section" style="padding-top: 120px;">
        <div class="container">
            <h1 class="section-title" style="color: white;">
                📋 Minhas Candidaturas
                <span class="badge"><?= count($candidaturas) ?></span>
            </h1>

            <?php if (count($candidaturas) === 0): ?>
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3>Nenhuma candidatura ainda</h3>
                    <p>Você ainda não se candidatou a nenhuma vaga.</p>
                    <a href="../index.php" class="btn btn-primary">Ver vagas disponíveis</a>
                </div>
            <?php else: ?>
                <div class="vagas-grid">
                    <?php foreach ($candidaturas as $cand): ?>
                        <?php
                        $vaga = $vagaDAO->buscarPorId($cand["id_vaga"]);
                        if (!$vaga) continue;
                        ?>
                        <div class="vaga-card">
                            <?php if (!empty($vaga["imagem"])): ?>
                                <div class="vaga-image">
                                    <img src="../uploads/<?= htmlspecialchars($vaga["imagem"]) ?>" 
                                         alt="<?= htmlspecialchars($vaga["titulo"]) ?>">
                                </div>
                            <?php else: ?>
                                <div class="vaga-image vaga-image-placeholder">
                                    <span class="placeholder-icon">💼</span>
                                </div>
                            <?php endif; ?>

                            <div class="vaga-content">
                                <span class="vaga-categoria" style="background: var(--success);">
                                    ✅ Candidatado
                                </span>
                                <h3 class="vaga-titulo"><?= htmlspecialchars($vaga["titulo"]) ?></h3>
                                <p class="vaga-descricao">
                                    <?= nl2br(htmlspecialchars(substr($vaga["descricao"], 0, 100))) ?>...
                                </p>
                                
                                <div class="vaga-footer">
                                    <span class="vaga-contato">
                                        📅 <?= date("d/m/Y", strtotime($cand["data_candidatura"])) ?>
                                    </span>
                                    
                                    <a href="descandidatar.php?id_vaga=<?= $vaga["id"] ?>" 
                                       class="btn btn-danger btn-small"
                                       onclick="return confirm('Deseja cancelar sua candidatura?')">
                                        ❌ Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?= date("Y") ?> VagasJob - Todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html>