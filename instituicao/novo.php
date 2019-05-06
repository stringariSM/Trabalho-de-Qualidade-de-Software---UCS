<?php
    $db = new Database();


    if( isset($_GET['id']) && !empty($_GET['id']) ){
        $id_edicao = $_GET['id'];
        $edicao = $db->query("SELECT * FROM instituicao WHERE id = $id_edicao");
    }

    if( isset($_POST) && !empty($_POST) ){
        $data = $_POST;
        $transacao = $db->insert('instituicao', $data);
        ?>
            <h1>Registro Inserido com sucesso!</h1>
        <?php
        die();
    }
?>

<form name="formulario" method="post">
    <?php if($edicao){ ?>
        <input type="hidden" name="id" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->id : NULL; ?>" />
    <?php } ?>
    <div class="form-row">
        <div class="col-sm-9">
            <label>Nome da Instituição*</label>
            <input type="text" class="form-control" name="nome" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->nome : NULL; ?>" required>
        </div>
        <div class="col-sm-3">
            <label>CNPJ*</label>
            <input type="text" class="form-control" name="cnpj" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->cnpj : NULL; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-2">
            <label>CEP*</label>
            <input type="text" class="form-control" name="cep" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->cep : NULL; ?>" required>
        </div>
        <div class="col-sm-9">
            <label>Endereço*</label>
            <input type="text" class="form-control" name="endereco" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->endereco : NULL; ?>" required>
        </div>
        <div class="col-sm-1">
            <label>Número*</label>
            <input type="text" class="form-control" name="numero" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->numero : NULL; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-12">
            <label>Complemento*</label>
            <input type="text" class="form-control" name="complemento" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->complemento : NULL; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-5">
            <label>Bairro*</label>
            <input type="text" class="form-control" name="bairro" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->bairro : NULL; ?>" required>
        </div>
        <div class="col-sm-6">
            <label>Cidade*</label>
            <input type="text" class="form-control" name="cidade" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->cidade : NULL; ?>" required>
        </div>
        <div class="col-sm-1">
            <label>UF*</label>
            <input type="text" class="form-control" name="uf" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->uf : NULL; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-12">
            <label>Tipo*</label>
            <select class="form-control" name="tipo">
                <option selected>1</option>
            </select>
        </div>
    </div>

    <div class="text-center mt-5">
        <button type="button" class="btn btn-danger" onclick="javascript:document.location.href='/aula/instituicao/listagem';">
            Cancelar
        </button>
        <button type="submit" class="btn btn-success">Cadastrar</button>
    </div>
</form>