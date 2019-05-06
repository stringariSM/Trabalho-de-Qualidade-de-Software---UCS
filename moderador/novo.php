<?php
    $db = new Database();
    $instituicao = $db->query("SELECT * FROM instituicao");

    if(!is_array($instituicao)){
        $instituicao = array($instituicao);
    }

    if( isset($_GET['id']) && !empty($_GET['id']) ){
        $id_edicao = $_GET['id'];
        $edicao = $db->query("SELECT * FROM moderador WHERE id = $id_edicao");
    }

    if( isset($_POST) && !empty($_POST) ){
        $data = $_POST;

        $linhas = explode('<br />', nl2br($data["descricao_experiencia"]));
        if(count($linhas) >= 2){
            $transacao = $db->insert('moderador', $data);
            ?>
                <h1>Registro Inserido com sucesso!</h1>
            <?php
            die();
        }else{
            ?>
                <h5>O campo descrição precisa ter no mínimo 2 linhas</h5>
                <div class="text-center mt-5">
                    <button type="button" class="btn btn-danger" onclick="javascript:history.go(-1)">
                        Voltar
                    </button>
                </div>
            <?php
        }
    }
?>

<form name="formulario" method="post">
    <?php if($edicao){ ?>
        <input type="hidden" name="id" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->id : NULL; ?>" />
    <?php } ?>
    <div class="form-row">
        <div class="col-sm-9">
            <label>Nome*</label>
            <input type="text" class="form-control" name="nome" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->nome : NULL; ?>" required>
        </div>
        <div class="col-sm-3">
            <label>Data de Nascimento*</label>
            <input type="date" class="form-control" name="data_nascimento" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->data_nascimento : NULL; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-6">
            <label>Instituição*</label>
            <select class="form-control" name="id_instituicao" required>
                <option selected>Selecione...</option>
                <?php foreach($instituicao as $key => $value){ ?>
                    <option value="<?php echo $value->id; ?>"><?php echo $value->nome; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-sm-6">
            <label>Função*</label>
            <select class="form-control" name="funcao" required>
                <option value="1">Professor</option>
                <option value="2">Aluno</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-12">
            <label>E-mail*</label>
            <input type="text" class="form-control" name="email" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->email : NULL; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-6">
            <label>Data Inicial*</label>
            <input type="date" class="form-control" name="data_inicial" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->data_inicial : NULL; ?>" required>
        </div>
        <div class="col-sm-6">
            <label>Data Final*</label>
            <input type="date" class="form-control" name="data_final" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->data_final : NULL; ?>" required>
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-12">
            <label>Descrição*</label>
            <textarea rows="5" class="form-control" required name="descricao_experiencia"><?php echo isset($edicao) && !empty($edicao) ? $edicao->descricao_experiencia : NULL; ?></textarea>
        </div>
    </div>

    <div class="form-row">
        <div class="col-sm-12">
            <label>Protocolo*</label>
            <?php
            $moderador = $db->query("SELECT MAX(id) + 4 AS codigo FROM moderador");

            function fibonacci($q, $zero = false){
                if($q >= 2){
                    $f = ($zero) ? [0,1] : [1,1];
                    for($i = 2; $i < $q; $i++){
                        $f[$i] = $f[$i-1] + $f[$i-2];
                    }
                    return $f;
                }
                return ($q == 1) ? [1] : [];
            }

            $protocoloArray = fibonacci($moderador->codigo);
            if(is_array($protocoloArray)){
                foreach($protocoloArray as $keyProtocolo => $valProtocolo){
                    $protocolo .= $valProtocolo;
                }
            }
            ?>
            <input type="text" class="form-control" readonly name="numero_protocolo" value="<?php echo isset($edicao) && !empty($edicao) ? $edicao->numero_protocolo : $protocolo; ?>" required>
        </div>
    </div>


    <div class="text-center mt-5">
        <button type="button" class="btn btn-danger" onclick="javascript:document.location.href='/aula/moderador/listagem';">
            Cancelar
        </button>
        <button type="submit" class="btn btn-success">Cadastrar</button>
    </div>
</form>