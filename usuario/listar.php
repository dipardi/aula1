<?php
include_once "../class/usuario.DAO.class.php";
$objUsuarioDAO = new usuarioDAO();
$retorno = $objUsuarioDAO->listar();
if(isset($_GET['seucesso'])){
    if($_GET["seucesso"]=="inserir"){
        echo "<h2>Inserido com sucesso!</h2>"
    }

}
?>
<table>
    <thead>
        <th>ID</th>
                <th>Nome</th>
                        <th>Email</th>
                                <th>Senha</th>
                                        <th>ID</th>

    </thead>
    <tbody>
        <?php
        foreach($retorno as $linha){
            ?>
            <tr>
            <td><?=$linha["id"]?></td>
            <td><?=$linha["nomes"]?></td>
            <td><?=$linha["email"]?></td>
            <td><?=$linha["senha"]?></td>
            </tr>
            <?php
        }
        ?>

    </tbody>
</table>