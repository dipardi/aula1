<?php
session_start();

// aqui você poderia checar se é admin, se quiser
// if (!isset($_SESSION["login"])) { header("Location: ../site/Login.php"); exit; }

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
    <title>Inscritos na vaga</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- ADICIONAR -->
</head>
<body>
<div class="container"> <!-- ADICIONAR -->



    <h1>Inscritos na vaga: <?= htmlspecialchars($vaga["titulo"]) ?></h1>

    <p><strong>Categoria:</strong> <?= htmlspecialchars($categoria["nome"] ?? "Sem categoria") ?></p>
    <p><strong>Status:</strong> <?= $vaga["ativa"] == 1 ? "Ativa" : "Desativada" ?></p>

    <p><a href="vagas_cadastrar.php">Voltar para lista de vagas</a></p>

    <hr>

    <?php if (count($inscritos) === 0): ?>
        <p>Nenhum candidato inscrito nesta vaga ainda.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
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
                                 width="60">
                        <?php else: ?>
                            Sem foto
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($i["nome"]) ?></td>
                    <td><?= htmlspecialchars($i["email"]) ?></td>
                    <td>
                        <?php if (!empty($i["linkedin"])): ?>
                            <a href="<?= htmlspecialchars($i["linkedin"]) ?>" target="_blank">
                                Ver perfil
                            </a>
                        <?php else: ?>
                            Não informado
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($i["data_candidatura"]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>

    <!-- formulário de vaga + tabela de vagas -->
</div> <!-- ADICIONAR -->
</body>
</html>
