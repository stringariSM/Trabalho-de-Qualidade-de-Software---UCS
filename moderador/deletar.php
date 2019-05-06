<?php
    $db = new Database();

    if( isset($_GET['id']) && !empty($_GET['id']) ){
        $id = $_GET['id'];

        $delete = $db->delete('moderador', $id);
        if($delete){
            echo 'Apagado.';
        }
    }else{
        echo 'Nenhuma instituição selecionada.';
    }
?>

<div class="text-center mt-5">
    <button type="button" class="btn btn-danger" onclick="javascript:document.location.href='/aula/moderador/listagem';">
        Ir para listagem
    </button>
</div>