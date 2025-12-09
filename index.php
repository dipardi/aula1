<?php
session_start();

include_once "class/VagaDAO.php";
include_once "class/CategoriaDAO.php";

$vagaDAO = new VagaDAO();
$categoriaDAO = new CategoriaDAO();

// Pega categorias para o filtro
$categorias = $categoriaDAO->listar();

// Verifica se tem filtro de categoria
$idCategoriaSelecionada = isset($_GET["categoria"]) ? (int)$_GET["categoria"] : 0;

// Busca vagas (ativas apenas)
if ($idCategoriaSelecionada > 0) {
    $vagas = $vagaDAO->listarAtivasPorCategoria($idCategoriaSelecionada);
} else {
    $vagas = $vagaDAO->listarAtivas();
}

// Verifica se está logado
$logado = isset($_SESSION["login"]) && $_SESSION["login"] === true;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IFsul Vagas - Portal de Oportunidades</title>
    <link rel="stylesheet" href="assets/style_ifsul.css">
</head>
<body>
    <!-- HEADER FIXO -->
    <header class="header">
        <div class="header-container">
            <div class="logo">
                <span class="logo-ifsul">🎓</span>
                <h2>IFsul Vagas</h2>
            </div>
            
            <nav class="nav-buttons">
                <?php if ($logado): ?>
                    <span class="user-welcome">Olá, <?= htmlspecialchars($_SESSION["nome"]) ?>!</span>
                    <a href="usuario/minhas_candidaturas.php" class="btn btn-outline">📋 Minhas Candidaturas</a>
                    <a href="site/logout.php" class="btn btn-danger">🚪 Sair</a>
                <?php else: ?>
                    <a href="cadastro.php" class="btn btn-success">✅ Cadastrar</a>
                    <a href="login.php" class="btn btn-primary">🔐 Login</a>
                    <a href="login_admin.php" class="btn btn-admin">⚙️ Admin</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">🎯 VENHA TRABALHAR NO IFSUL</div>
                <h1 class="hero-title">Encontre Sua Oportunidade no IFsul</h1>
                <p class="hero-subtitle">Portal de vagas para a comunidade acadêmica e profissional</p>
                <p class="hero-ifsul">⭐ Instituto Federal Sul-rio-grandense - Campus em todo o RS</p>
            </div>
            
            <?php
            // Mensagens de feedback
            if (isset($_GET["msg"])) {
                echo '<div style="margin-top: 24px;">';
                if ($_GET["msg"] === "ok") {
                    echo '<div class="alert alert-success">✅ Candidatura realizada com sucesso!</div>';
                } elseif ($_GET["msg"] === "ja") {
                    echo '<div class="alert alert-warning">⚠️ Você já se candidatou a esta vaga.</div>';
                } elseif ($_GET["msg"] === "removida") {
                    echo '<div class="alert alert-error">❌ Candidatura cancelada com sucesso.</div>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <!-- FILTRO DE CATEGORIAS -->
    <section class="filter-section">
        <div class="container">
            <div class="filter-card">
                <form method="get" action="index.php" class="filter-form">
                    <label for="categoria">🔍 Filtrar por categoria:</label>
                    <select name="categoria" id="categoria" onchange="this.form.submit()">
                        <option value="0">📂 Todas as categorias</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat["id"] ?>"
                                <?= ($idCategoriaSelecionada === (int)$cat["id"]) ? "selected" : "" ?>>
                                <?= htmlspecialchars($cat["nome"]) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
                
                <?php if ($idCategoriaSelecionada > 0): ?>
                    <a href="index.php" class="btn-clear-filter">🔄 Limpar filtro</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- LISTA DE VAGAS -->
    <section class="vagas-section">
        <div class="container">
            <h2 class="section-title">
                💼 <?php if ($idCategoriaSelecionada > 0): ?>
                    Vagas Filtradas
                <?php else: ?>
                    Todas as Vagas Disponíveis
                <?php endif; ?>
                <span class="badge"><?= count($vagas) ?></span>
            </h2>

            <?php if (count($vagas) === 0): ?>
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3>Nenhuma vaga encontrada</h3>
                    <p>Não há vagas disponíveis nesta categoria no momento.</p>
                    <a href="index.php" class="btn btn-primary">Ver todas as vagas</a>
                </div>
            <?php else: ?>
                <div class="vagas-grid">
                    <?php foreach ($vagas as $vaga): ?>
                        <div class="vaga-card">
                            <?php if (!empty($vaga["imagem"])): ?>
                                <div class="vaga-image">
                                    <img src="uploads/<?= htmlspecialchars($vaga["imagem"]) ?>" 
                                         alt="<?= htmlspecialchars($vaga["titulo"]) ?>">
                                </div>
                            <?php else: ?>
                                <div class="vaga-image vaga-image-placeholder">
                                    <span class="placeholder-icon">💼</span>
                                </div>
                            <?php endif; ?>

                            <div class="vaga-content">
                                <span class="vaga-categoria"><?= htmlspecialchars($vaga["categoria"]) ?></span>
                                <h3 class="vaga-titulo"><?= htmlspecialchars($vaga["titulo"]) ?></h3>
                                <p class="vaga-descricao"><?= nl2br(htmlspecialchars(substr($vaga["descricao"], 0, 120))) ?>...</p>
                                
                                <div class="vaga-footer">
                                    <span class="vaga-contato">📧 <?= htmlspecialchars($vaga["contato"]) ?></span>
                                    
                                    <?php if ($logado): ?>
                                        <?php
                                        include_once "class/CandidaturaDAO.php";
                                        $candDAO = new CandidaturaDAO();
                                        $jaCandidatou = $candDAO->jaCandidatou($_SESSION["id"], $vaga["id"]);
                                        ?>
                                        
                                        <?php if ($jaCandidatou): ?>
                                            <a href="usuario/descandidatar.php?id_vaga=<?= $vaga["id"] ?>" 
                                               class="btn btn-danger btn-small"
                                               onclick="return confirm('Deseja cancelar sua candidatura?')">
                                                ❌ Cancelar
                                            </a>
                                        <?php else: ?>
                                            <a href="usuario/candidatar.php?id_vaga=<?= $vaga["id"] ?>" 
                                               class="btn btn-success btn-small">
                                                ✅ Candidatar-se
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="login.php?redirect=index.php" class="btn btn-primary btn-small">
                                            🔐 Fazer login
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p>&copy; <?= date("Y") ?> <span class="footer-ifsul">IFsul Vagas</span> - Portal de Oportunidades</p>
                <p>🎓 Instituto Federal Sul-rio-grandense - Educação de Excelência</p>
            </div>
        </div>
    </footer>
</body>
</html>