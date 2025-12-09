<?php
session_start();

include_once "../class/categoria.class.php";
include_once "../class/CategoriaDAO.php";
include_once "../class/vaga.class.php";
include_once "../class/VagaDAO.php";

$catDAO  = new CategoriaDAO();
$vagaDAO = new VagaDAO();

// Se enviou o formulário, cadastra a vaga
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo      = trim($_POST["titulo"] ?? "");
    $descricao   = trim($_POST["descricao"] ?? "");
    $contato     = trim($_POST["contato"] ?? "");
    $idCategoria = (int)($_POST["categoria"] ?? 0);

    // Tratamento da imagem (opcional)
    $nomeImagem = "";
    if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === UPLOAD_ERR_OK) {
        $nomeOriginal = $_FILES["imagem"]["name"];
        $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);

        $nomeImagem = uniqid("vaga_") . "." . $extensao;
        $caminhoDestino = "../uploads/" . $nomeImagem;
        move_uploaded_file($_FILES["imagem"]["tmp_name"], $caminhoDestino);
    }

    // Cria objeto vaga
    $vaga = new Vaga();
    $vaga->setUniversal("titulo", $titulo);
    $vaga->setUniversal("descricao", $descricao);
    $vaga->setUniversal("contato", $contato);
    $vaga->setUniversal("imagem", $nomeImagem);
    $vaga->setUniversal("ativa", 1);
    $vaga->setUniversal("id_categoria", $idCategoria);

    $vagaDAO->inserir($vaga);

    header("Location: vagas_cadastrar.php?msg=cadastrada");
    exit;
}

// Carrega categorias para o select
$categorias = $catDAO->listar();
// Carrega vagas para listar embaixo
$vagas = $vagaDAO->listarTodas();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Vagas | IFsul Vagas</title>
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
            font-size: 2rem;
            margin-bottom: 8px;
        }
        
        .page-title .breadcrumb {
            color: var(--cinza);
            font-size: 0.9rem;
        }
        
        .page-title .breadcrumb a {
            color: var(--ifsul-verde);
            text-decoration: none;
        }
        
        .form-section {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: var(--sombra);
            margin-bottom: 28px;
        }
        
        .form-section h2 {
            color: var(--ifsul-verde-escuro);
            font-size: 1.4rem;
            margin-bottom: 20px;
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
        
        textarea {
            min-height: 120px;
            resize: vertical;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="page-title">
        <h1>💼 Gerenciar Vagas</h1>
        <p class="breadcrumb">
            <a href="dashboard.php">Dashboard</a> / Vagas
        </p>
    </div>

    <?php
    if (isset($_GET["msg"])) {
        if ($_GET["msg"] === "cadastrada") {
            echo '<div class="alert alert-success">✅ Vaga cadastrada com sucesso!</div>';
        } elseif ($_GET["msg"] === "ativada") {
            echo '<div class="alert alert-success">✅ Vaga ativada com sucesso!</div>';
        } elseif ($_GET["msg"] === "desativada") {
            echo '<div class="alert alert-warning">⚠️ Vaga desativada com sucesso!</div>';
        }
    }
    ?>

    <div class="form-section">
        <h2>➕ Cadastrar Nova Vaga</h2>

        <form method="post" enctype="multipart/form-data">
            <label>Título da vaga:</label>
            <input type="text" name="titulo" required placeholder="Ex: Professor de Matemática">

            <label>Descrição da vaga:</label>
            <textarea name="descricao" required placeholder="Descreva os requisitos, responsabilidades..."></textarea>

            <label>Contato (email, telefone, etc.):</label>
            <input type="text" name="contato" placeholder="contato@ifsul.edu.br">

            <label>Imagem da vaga (opcional):</label>
            <input type="file" name="imagem">

            <label>Categoria:</label>
            <select name="categoria" required>
                <option value="">Selecione uma categoria</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat["id"] ?>">
                        <?= htmlspecialchars($cat["nome"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn btn-success" style="margin-top: 12px;">✅ Cadastrar Vaga</button>
        </form>
    </div>

    <div class="table-section" id="lista">
        <h2>📋 Vagas Cadastradas</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoria</th>
                <th>Status</th>
                <th>Contato</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($vagas as $vaga): ?>
                <tr>
                    <td><?= $vaga["id"] ?></td>
                    <td><?= htmlspecialchars($vaga["titulo"]) ?></td>
                    <td><?= htmlspecialchars($vaga["categoria"]) ?></td>
                    <td>
                        <?php if ($vaga["ativa"] == 1): ?>
                            <span style="color: var(--ifsul-verde); font-weight: 600;">✅ Ativa</span>
                        <?php else: ?>
                            <span style="color: var(--erro); font-weight: 600;">❌ Desativada</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($vaga["contato"]) ?></td>
                    <td>
                        <?php if ($vaga["ativa"] == 1): ?>
                            <a href="vaga_status.php?id=<?= $vaga["id"] ?>&ativa=0" class="btn btn-danger btn-small">❌ Desativar</a>
                        <?php else: ?>
                            <a href="vaga_status.php?id=<?= $vaga["id"] ?>&ativa=1" class="btn btn-success btn-small">✅ Ativar</a>
                        <?php endif; ?>
                         | 
                        <a href="vaga_inscritos.php?id_vaga=<?= $vaga["id"] ?>" class="btn btn-primary btn-small">
                            👥 Inscritos
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>
</body>
</html>