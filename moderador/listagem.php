<?php
    $db = new Database();
    $resultModerador = $db->query("SELECT * FROM moderador");

    $result = array();
    if(count($resultModerador) == 1){
        $result[] = $resultModerador;
    }else{
        $result = $resultModerador;
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
            <th>Nome</th>
            <th>Data Nascimento</th>
            <th>Protocolo</th>
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
            <td><?php echo $value->data_nascimento;?></td>
            <td><?php echo $value->numero_protocolo;?></td>
            <td>
                <a href="/aula/moderador/novo?id=<?php echo $value->id;?>" class="btn btn-primary">
                    Editar
                </a>

                <a href="/aula/moderador/deletar?id=<?php echo $value->id;?>" class="btn btn-danger">
                    Excluir
                </a>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>