<?php
    $db = new Database();

    if( isset($_GET['id']) && !empty($_GET['id']) ){
        $id = $_GET['id'];

        $result = $db->query("SELECT count(*) as qtd FROM moderador WHERE id_instituicao = $id");

        if($result->qtd > 0){
            echo 'Não posível excluir, pois existem moderadores cadastrados';

        }else{
            $delete = $db->delete('instituicao', $id);
            if($delete){
                echo 'Apagado.';
            }
        }
    }else{
        echo 'Nenhuma instituição selecionada.';
    }
?>

<div class="text-center mt-5">
    <button type="button" class="btn btn-danger" onclick="javascript:document.location.href='/aula/instituicao/listagem';">
        Ir para listagem
    </button>
</div>