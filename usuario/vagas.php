<?php
session_start();

// só permite acesso se estiver logado
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: ../site/Login.php?erro=2");
    exit;
}

include_once "../class/vaga.class.php";
include_once "../class/VagaDAO.php";
include_once "../class/CandidaturaDAO.php";
include_once "../class/categoria.class.php";
include_once "../class/CategoriaDAO.php";

$vagaDAO    = new VagaDAO();
$candDAO    = new CandidaturaDAO();
$categoriaDAO = new CategoriaDAO();

$idUsuario  = (int) $_SESSION["id"];

// pega categorias para o select
$categorias = $categoriaDAO->listar();

// pega categoria escolhida (se houver)
$idCategoriaSelecionada = isset($_GET["categoria"]) ? (int)$_GET["categoria"] : 0;

// decide quais vagas buscar
if ($idCategoriaSelecionada > 0) {
    $vagas = $vagaDAO->listarAtivasPorCategoria($idCategoriaSelecionada);
} else {
    $vagas = $vagaDAO->listarAtivas();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Vagas disponíveis</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- ADICIONAR -->
</head>
<body>
<div class="container"> <!-- ADICIONAR -->


    <h1>Vagas disponíveis</h1>

    <?php
    if (isset($_GET["msg"])) {
        if ($_GET["msg"] === "ok") {
            echo "<p style='color:green;'>Candidatura realizada com sucesso!</p>";
        } elseif ($_GET["msg"] === "ja") {
            echo "<p style='color:red;'>Você já se candidatou a esta vaga.</p>";
        } elseif ($_GET["msg"] === "removida") {
            echo "<p style='color:orange;'>Candidatura cancelada com sucesso.</p>";
        }
    }
    ?>

    <p>Olá, <?= htmlspecialchars($_SESSION["nome"]) ?>! Veja as vagas ativas abaixo:</p>
    <p><a href="../site/home.php">Voltar para a Home</a></p>

    <h3>Filtrar por categoria</h3>
    <form method="get" action="vagas.php">
        <select name="categoria">
            <option value="0">Todas as categorias</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat["id"] ?>"
                    <?= ($idCategoriaSelecionada === (int)$cat["id"]) ? "selected" : "" ?>>
                    <?= htmlspecialchars($cat["nome"]) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>

    <hr>

    <?php if (count($vagas) === 0): ?>
        <p>Não há vagas ativas para esse filtro.</p>
    <?php else: ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Contato</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($vagas as $vaga): ?>
                <tr>
                    <td><?= htmlspecialchars($vaga["titulo"]) ?></td>
                    <td><?= htmlspecialchars($vaga["categoria"]) ?></td>
                    <td><?= htmlspecialchars($vaga["contato"]) ?></td>
                    <td>
                        <?php if ($candDAO->jaCandidatou($idUsuario, $vaga["id"])): ?>
                            <a href="descandidatar.php?id_vaga=<?= $vaga["id"] ?>" style="color:red;">
                                Cancelar candidatura
                            </a>
                        <?php else: ?>
                            <a href="candidatar.php?id_vaga=<?= $vaga["id"] ?>" style="color:green;">
                                Me candidatar
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>
    <?php endif; ?>
</div> 
</body>
</html>
