<?php
session_start();

include_once "../class/VagaDAO.php";
include_once "../class/CandidaturaDAO.php";
include_once "../class/CategoriaDAO.php";

$idVaga = isset($_GET["id_vaga"]) ? (int)$_GET["id_vaga"] : 0;

if ($idVaga <= 0) {
    header("Location: vagas_cadastrar.php");
    exit;
}

$vagaDAO   = new VagaDAO();
$candDAO   = new CandidaturaDAO();
$catDAO    = new CategoriaDAO();

// pega dados da vaga
$vaga = $vagaDAO->buscarPorId($idVaga);
if (!$vaga) {
    header("Location: vagas_cadastrar.php");
    exit;
}

// pega nome da categoria
$categoria = $catDAO->buscarPorId((int)$vaga["id_categoria"]);

// pega inscritos
$inscritos = $candDAO->listarPorVaga($idVaga);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inscritos na Vaga | IFsul Vagas</title>
    <link rel="stylesheet" href="../assets/style_ifsul.css">
    <style>
        body {
            background: #f0f2f5;
        }
        
        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 32px;
        }
        
        .page-title {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--sombra);
            border-left: 6px solid var(--ifsul-verde);
            margin-bottom: 28px;
        }
        
        .page-title h1 {
            color: var(--ifsul-verde-escuro);
            font-size: 1.8rem;
            margin-bottom: 12px;
        }
        
        .page-title .breadcrumb {
            color: var(--cinza);
            font-size: 0.9rem;
        }
        
        .page-title .breadcrumb a {
            color: var(--ifsul-verde);
            text-decoration: none;
        }
        
        .vaga-info {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--sombra);
            margin-bottom: 28px;
        }
        
        .vaga-info h3 {
            color: var(--ifsul-verde-escuro);
            margin-bottom: 12px;
            font-size: 1.2rem;
        }
        
        .vaga-info p {
            margin-bottom: 8px;
            color: var(--cinza-escuro);
        }
        
        .table-section {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: var(--sombra);
        }
        
        .table-section h2 {
            color: var(--ifsul-verde-escuro);
            font-size: 1.4rem;
            margin-bottom: 20px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-ativa {
            background: rgba(46, 204, 113, 0.15);
            color: var(--ifsul-verde-escuro);
        }
        
        .status-desativada {
            background: rgba(231, 76, 60, 0.15);
            color: var(--erro);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-title">
        <h1>👥 Inscritos na Vaga: <?= htmlspecialchars($vaga["titulo"]) ?></h1>
        <p class="breadcrumb">
            <a href="dashboard.php">Dashboard</a> / 
            <a href="vagas_cadastrar.php">Vagas</a> / 
            Inscritos
        </p>
    </div>

    <div class="vaga-info">
        <h3>ℹ️ Informações da Vaga</h3>
        <p><strong>Categoria:</strong> <?= htmlspecialchars($categoria["nome"] ?? "Sem categoria") ?></p>
        <p>
            <strong>Status:</strong> 
            <?php if ($vaga["ativa"] == 1): ?>
                <span class="status-badge status-ativa">✅ Ativa</span>
            <?php else: ?>
                <span class="status-badge status-desativada">❌ Desativada</span>
            <?php endif; ?>
        </p>
        <p><strong>Total de candidatos:</strong> <?= count($inscritos) ?></p>
        
        <a href="vagas_cadastrar.php" class="btn btn-primary" style="margin-top: 12px;">
            ← Voltar para lista de vagas
        </a>
    </div>

    <div class="table-section">
        <?php if (count($inscritos) === 0): ?>
            <div style="text-align: center; padding: 40px;">
                <div style="font-size: 3rem; margin-bottom: 16px;">📭</div>
                <h3 style="color: var(--cinza); margin-bottom: 8px;">Nenhum candidato inscrito</h3>
                <p style="color: var(--cinza);">Esta vaga ainda não possui candidaturas.</p>
            </div>
        <?php else: ?>
            <h2>📋 Lista de Candidatos (<?= count($inscritos) ?>)</h2>
            <table>
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>LinkedIn</th>
                    <th>Data candidatura</th>
                </tr>

                <?php foreach ($inscritos as $i): ?>
                    <tr>
                        <td>
                            <?php if (!empty($i["imagem"])): ?>
                                <img src="../uploads/<?= htmlspecialchars($i["imagem"]) ?>" 
                                     alt="Foto de <?= htmlspecialchars($i["nome"]) ?>" 
                                     width="60" 
                                     style="border-radius: 50%; object-fit: cover; height: 60px;">
                            <?php else: ?>
                                <div style="width: 60px; height: 60px; background: var(--ifsul-verde); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.5rem;">
                                    <?= strtoupper(substr($i["nome"], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= htmlspecialchars($i["nome"]) ?></strong></td>
                        <td><?= htmlspecialchars($i["email"]) ?></td>
                        <td>
                            <?php if (!empty($i["linkedin"])): ?>
                                <a href="<?= htmlspecialchars($i["linkedin"]) ?>" target="_blank" class="btn btn-primary btn-small">
                                    🔗 Ver perfil
                                </a>
                            <?php else: ?>
                                <span style="color: var(--cinza);">Não informado</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date("d/m/Y H:i", strtotime($i["data_candidatura"])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>

</div>
</body>
</html>