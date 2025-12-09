<?php
session_start();

// Verifica se é admin
if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header("Location: ../login_admin.php");
    exit;
}

include_once "../class/VagaDAO.php";
include_once "../class/CategoriaDAO.php";
include_once "../class/CandidaturaDAO.php";

$vagaDAO = new VagaDAO();
$catDAO = new CategoriaDAO();
$candDAO = new CandidaturaDAO();

// Estatísticas
$vagas = $vagaDAO->listarTodas();
$categorias = $catDAO->listar();
$totalVagas = count($vagas);
$vagasAtivas = count(array_filter($vagas, fn($v) => $v["ativa"] == 1));
$totalCategorias = count($categorias);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - IFsul Vagas</title>
    <link rel="stylesheet" href="../assets/style_ifsul.css">
    <style>
        body {
            background: #f0f2f5;
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* SIDEBAR */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, var(--ifsul-verde) 0%, var(--ifsul-verde-escuro) 100%);
            color: white;
            padding: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(46, 204, 113, 0.3);
        }
        
        .sidebar-header {
            padding: 32px 24px;
            background: rgba(0,0,0,0.15);
            border-bottom: 3px solid white;
        }
        
        .sidebar-logo {
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 12px;
        }
        
        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 8px;
            text-align: center;
            font-weight: 700;
        }
        
        .sidebar-header .admin-badge {
            font-size: 0.85rem;
            opacity: 0.95;
            text-align: center;
            background: white;
            color: var(--ifsul-verde-escuro);
            padding: 6px 12px;
            border-radius: 20px;
            display: inline-block;
            width: 100%;
            font-weight: 600;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 24px 16px;
        }
        
        .sidebar-menu li {
            margin-bottom: 8px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            color: white;
            text-decoration: none;
            border-radius: 12px;
            transition: var(--transicao);
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(4px);
            border-left: 4px solid white;
        }
        
        .sidebar-menu .icon {
            font-size: 1.3rem;
        }
        
        .sidebar-footer {
            padding: 24px;
            border-top: 1px solid rgba(255,255,255,0.2);
            margin-top: auto;
        }
        
        /* MAIN CONTENT */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 40px;
            background: #f0f2f5;
        }
        
        .page-header {
            margin-bottom: 36px;
            background: white;
            padding: 32px;
            border-radius: 16px;
            box-shadow: var(--sombra);
            border-left: 6px solid var(--ifsul-verde);
        }
        
        .page-header h1 {
            font-size: 2.2rem;
            color: var(--ifsul-verde-escuro);
            margin-bottom: 8px;
            font-weight: 700;
        }
        
        .page-header p {
            color: var(--cinza);
            font-size: 1.05rem;
        }
        
        /* CARDS DE ESTATÍSTICAS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: var(--sombra);
            transition: var(--transicao);
            border-top: 4px solid var(--ifsul-verde);
        }
        
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--sombra-xl);
        }
        
        .stat-card .icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 16px;
            background: rgba(46, 204, 113, 0.15);
        }
        
        .stat-card h3 {
            font-size: 2.5rem;
            color: var(--ifsul-verde-escuro);
            margin-bottom: 4px;
            font-weight: 700;
        }
        
        .stat-card p {
            color: var(--cinza);
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        /* QUICK ACTIONS */
        .actions-section {
            background: white;
            padding: 36px;
            border-radius: 16px;
            box-shadow: var(--sombra);
        }
        
        .actions-section h2 {
            font-size: 1.6rem;
            margin-bottom: 28px;
            color: var(--ifsul-verde-escuro);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        
        .action-card {
            padding: 28px;
            border: 3px solid var(--cinza-medio);
            border-radius: 16px;
            text-align: center;
            transition: var(--transicao);
            text-decoration: none;
            color: var(--cinza-escuro);
            background: var(--cinza-claro);
        }
        
        .action-card:hover {
            border-color: var(--ifsul-verde);
            background: white;
            transform: translateY(-6px);
            box-shadow: var(--sombra-lg);
        }
        
        .action-card .icon {
            font-size: 3rem;
            margin-bottom: 16px;
        }
        
        .action-card h3 {
            font-size: 1.15rem;
            margin-bottom: 6px;
            color: var(--ifsul-verde-escuro);
            font-weight: 700;
        }
        
        .action-card p {
            font-size: 0.85rem;
            color: var(--cinza);
        }
        
        @media (max-width: 968px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .admin-layout {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">🎓</div>
                <h2>IFsul Admin</h2>
                <p class="admin-badge">👋 Olá, <?= htmlspecialchars($_SESSION["admin_nome"]) ?></p>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="dashboard.php" class="active">
                        <span class="icon">📊</span> Dashboard
                    </a>
                </li>
                <li>
                    <a href="vagas_cadastrar.php">
                        <span class="icon">💼</span> Gerenciar Vagas
                    </a>
                </li>
                <li>
                    <a href="categorias.php">
                        <span class="icon">📂</span> Categorias
                    </a>
                </li>
                <li>
                    <a href="../index.php" target="_blank">
                        <span class="icon">🌐</span> Ver Site Público
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <a href="logout.php" class="btn btn-danger" style="width: 100%;">
                    🚪 Sair do Painel
                </a>
            </div>
        </aside>
        
        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="page-header">
                <h1>📊 Dashboard Administrativo</h1>
                <p>Visão geral do sistema IFsul Vagas</p>
            </div>
            
            <!-- ESTATÍSTICAS -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="icon">💼</div>
                    <h3><?= $totalVagas ?></h3>
                    <p>Total de Vagas Cadastradas</p>
                </div>
                
                <div class="stat-card">
                    <div class="icon">✅</div>
                    <h3><?= $vagasAtivas ?></h3>
                    <p>Vagas Ativas no Momento</p>
                </div>
                
                <div class="stat-card">
                    <div class="icon">📂</div>
                    <h3><?= $totalCategorias ?></h3>
                    <p>Categorias Disponíveis</p>
                </div>
            </div>
            
            <!-- AÇÕES RÁPIDAS -->
            <div class="actions-section">
                <h2>⚡ Ações Rápidas</h2>
                <div class="actions-grid">
                    <a href="vagas_cadastrar.php" class="action-card">
                        <div class="icon">➕</div>
                        <h3>Nova Vaga</h3>
                        <p>Cadastrar oportunidade</p>
                    </a>
                    
                    <a href="categorias.php" class="action-card">
                        <div class="icon">🏷️</div>
                        <h3>Nova Categoria</h3>
                        <p>Criar categoria</p>
                    </a>
                    
                    <a href="vagas_cadastrar.php#lista" class="action-card">
                        <div class="icon">📋</div>
                        <h3>Listar Vagas</h3>
                        <p>Ver todas as vagas</p>
                    </a>
                    
                    <a href="../index.php" target="_blank" class="action-card">
                        <div class="icon">👀</div>
                        <h3>Ver Site</h3>
                        <p>Visão do usuário</p>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>