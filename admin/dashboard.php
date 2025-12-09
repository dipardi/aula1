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
    <title>Dashboard Admin - VagasJob</title>
    <link rel="stylesheet" href="../assets/style_new.css">
    <style>
        body {
            background: #f3f4f6;
        }
        
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #7c3aed 0%, #5b21b6 100%);
            color: white;
            padding: 24px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }
        
        .sidebar-header {
            margin-bottom: 32px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 4px;
        }
        
        .sidebar-header .admin-badge {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .sidebar-menu li {
            margin-bottom: 8px;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: var(--transition);
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.2);
        }
        
        .sidebar-footer {
            margin-top: 32px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        
        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 40px;
        }
        
        .page-header {
            margin-bottom: 32px;
        }
        
        .page-header h1 {
            font-size: 2rem;
            color: var(--gray-900);
            margin-bottom: 8px;
        }
        
        .page-header p {
            color: var(--gray-600);
        }
        
        /* CARDS DE ESTATÍSTICAS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .stat-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
        }
        
        .stat-card.primary .icon {
            background: rgba(59, 130, 246, 0.1);
        }
        
        .stat-card.success .icon {
            background: rgba(16, 185, 129, 0.1);
        }
        
        .stat-card.purple .icon {
            background: rgba(124, 58, 237, 0.1);
        }
        
        .stat-card h3 {
            font-size: 2rem;
            color: var(--gray-900);
            margin-bottom: 4px;
        }
        
        .stat-card p {
            color: var(--gray-600);
            font-size: 0.9rem;
        }
        
        /* QUICK ACTIONS */
        .actions-section {
            background: white;
            padding: 32px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }
        
        .actions-section h2 {
            font-size: 1.5rem;
            margin-bottom: 24px;
            color: var(--gray-900);
        }
        
        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }
        
        .action-card {
            padding: 24px;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            text-align: center;
            transition: var(--transition);
            text-decoration: none;
            color: var(--gray-900);
        }
        
        .action-card:hover {
            border-color: var(--primary);
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }
        
        .action-card .icon {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }
        
        .action-card h3 {
            font-size: 1.1rem;
            margin-bottom: 4px;
        }
        
        .action-card p {
            font-size: 0.85rem;
            color: var(--gray-600);
        }
        
        @media (max-width: 768px) {
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
                <h2>👑 Admin Panel</h2>
                <p class="admin-badge">Olá, <?= htmlspecialchars($_SESSION["admin_nome"]) ?></p>
            </div>
            
            <ul class="sidebar-menu">
                <li>
                    <a href="dashboard.php" class="active">
                        <span>📊</span> Dashboard
                    </a>
                </li>
                <li>
                    <a href="vagas_cadastrar.php">
                        <span>💼</span> Gerenciar Vagas
                    </a>
                </li>
                <li>
                    <a href="categorias.php">
                        <span>📂</span> Categorias
                    </a>
                </li>
                <li>
                    <a href="../index.php" target="_blank">
                        <span>🌐</span> Ver Site
                    </a>
                </li>
            </ul>
            
            <div class="sidebar-footer">
                <a href="logout_admin.php" class="btn btn-danger" style="width: 100%;">
                    🚪 Sair
                </a>
            </div>
        </aside>
        
        <!-- MAIN CONTENT -->
        <main class="main-content">
            <div class="page-header">
                <h1>Dashboard</h1>
                <p>Visão geral do sistema de vagas</p>
            </div>
            
            <!-- ESTATÍSTICAS -->
            <div class="stats-grid">
                <div class="stat-card primary">
                    <div class="icon">💼</div>
                    <h3><?= $totalVagas ?></h3>
                    <p>Total de Vagas</p>
                </div>
                
                <div class="stat-card success">
                    <div class="icon">✅</div>
                    <h3><?= $vagasAtivas ?></h3>
                    <p>Vagas Ativas</p>
                </div>
                
                <div class="stat-card purple">
                    <div class="icon">📂</div>
                    <h3><?= $totalCategorias ?></h3>
                    <p>Categorias</p>
                </div>
            </div>
            
            <!-- AÇÕES RÁPIDAS -->
            <div class="actions-section">
                <h2>⚡ Ações Rápidas</h2>
                <div class="actions-grid">
                    <a href="vagas_cadastrar.php" class="action-card">
                        <div class="icon">➕</div>
                        <h3>Nova Vaga</h3>
                        <p>Cadastrar nova oportunidade</p>
                    </a>
                    
                    <a href="categorias.php" class="action-card">
                        <div class="icon">🏷️</div>
                        <h3>Nova Categoria</h3>
                        <p>Criar categoria de vaga</p>
                    </a>
                    
                    <a href="vagas_cadastrar.php#lista" class="action-card">
                        <div class="icon">📋</div>
                        <h3>Ver Todas</h3>
                        <p>Listar vagas cadastradas</p>
                    </a>
                    
                    <a href="../index.php" target="_blank" class="action-card">
                        <div class="icon">👀</div>
                        <h3>Visualizar Site</h3>
                        <p>Ver como usuário</p>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>