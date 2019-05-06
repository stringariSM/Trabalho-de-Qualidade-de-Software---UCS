<?php
    $db = new Database();
    $result = $db->query("SELECT * FROM instituicao");

    if(!is_array($result)){
        $result = array($result);
    }
?>

<div class="actions-bar">
    <a href="novo" class="btn btn-primary">
        Inserir Registro
    </a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Instituição</th>
            <th>CNPJ</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach ($result as $key => $value) {
    ?>
        <tr>
            <td><?php echo $value->id;?></td>
            <td><?php echo $value->nome;?></td>
            <td><?php echo $value->cnpj;?></td>
            <td>
                <a href="/aula/instituicao/novo?id=<?php echo $value->id;?>" class="btn btn-primary">
                    Editar
                </a>

                <a href="/aula/instituicao/deletar?id=<?php echo $value->id;?>" class="btn btn-danger">
                    Excluir
                </a>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>