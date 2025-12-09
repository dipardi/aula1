<?php
session_start();

// if (!isset($_SESSION["login"])) { header("Location: ../site/Login.php"); exit; }

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
    <title>Admin - Cadastro de Vagas</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- ADICIONAR -->
</head>
<body>
<div class="container"> <!-- ADICIONAR -->

    <h1>Admin - Cadastro de Vagas</h1>

    <?php
    if (isset($_GET["msg"])) {
        if ($_GET["msg"] === "cadastrada") {
            echo "<p style='color:green;'>Vaga cadastrada com sucesso!</p>";
        } elseif ($_GET["msg"] === "ativada") {
            echo "<p style='color:green;'>Vaga ativada com sucesso!</p>";
        } elseif ($_GET["msg"] === "desativada") {
            echo "<p style='color:red;'>Vaga desativada com sucesso!</p>";
        }
    }
    ?>

    <h2>Cadastrar nova vaga</h2>

    <form method="post" enctype="multipart/form-data">
        <label>Título da vaga:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label>Descrição da vaga:</label><br>
        <textarea name="descricao" rows="5" cols="40" required></textarea><br><br>

        <label>Contato (email, telefone, etc.):</label><br>
        <input type="text" name="contato"><br><br>

        <label>Imagem da vaga (opcional):</label><br>
        <input type="file" name="imagem"><br><br>

        <label>Categoria:</label><br>
        <select name="categoria" required>
            <option value="">Selecione uma categoria</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat["id"] ?>">
                    <?= htmlspecialchars($cat["nome"]) ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Cadastrar vaga</button>
    </form>

    <hr>

    <h2>Vagas cadastradas</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Categoria</th>
            <th>Ativa?</th>
            <th>Contato</th>
            <th>Ações</th>
        </tr>

        <?php foreach ($vagas as $vaga): ?>
            <tr>
                <td><?= $vaga["id"] ?></td>
                <td><?= htmlspecialchars($vaga["titulo"]) ?></td>
                <td><?= htmlspecialchars($vaga["categoria"]) ?></td>
                <td><?= $vaga["ativa"] == 1 ? "Sim" : "Não" ?></td>
                <td><?= htmlspecialchars($vaga["contato"]) ?></td>
                <td>
                    <?php if ($vaga["ativa"] == 1): ?>
                        <a href="vaga_status.php?id=<?= $vaga["id"] ?>&ativa=0">Desativar</a>
                    <?php else: ?>
                        <a href="vaga_status.php?id=<?= $vaga["id"] ?>&ativa=1">Ativar</a>
                    <?php endif; ?>
                     | 
                    <a href="vaga_inscritos.php?id_vaga=<?= $vaga["id"] ?>">
                        Ver inscritos
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <!-- formulário de vaga + tabela de vagas -->
</div> <!-- ADICIONAR -->
</body>
</html>
                        