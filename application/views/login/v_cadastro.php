<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php $this->load->view('main/headers'); ?>
    </head>
    <body style="background-color: #FFF;">
        <script>
            $(document).ready(function() { 
                $("#frmLogin").submit(function() { 
                    $("#dialogWait").modal('show');
                });
            });
        </script>
        <div id="dialogWait" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Aguarde...</h3>
                    </div>
                    <div class="modal-body">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active2"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="wrapper">
            <div class="container-fluid">
                <div id="page-login" class="row">
                    <div class="col-xs-12 col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-4">
                        <div class="box">
                            <div class="box-content">
                                <form class="form-signin" id="frmLogin" role="form" method="post" action="<?=base_url('login/cadastro');?>">
                                    <div class="text-center">
                                        <h1 class="page-header" style="font-size: 38px !important;">
                                            <img src="<?=base_url('images/logo.png');?>" style="height: 50px;" />
                                        </h1>
                                    </div>
                                    <?php
                                    if (isset($cadastrado)) {
                                    ?>
                                        <div class="alert alert-success">
                                            Seu cadastro foi realizado com sucesso e passará por uma análise! <br />
                                            Você receberá um e-mail assim que o seu acesso for aprovado!
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-lg btn-primary btn-block" href="<?=base_url('login');?>">Voltar</a>
                                        </div>
                                    <?php
                                    } else {
                                        if (isset($error)) {
                                        ?>
                                            <div class="<?=$type;?>" role="alert">
                                                <?=$error;?>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="form-group">
                                            <label class="control-label">Razão Social</label>
                                            <input type="text" class="form-control" placeholder="Razão Social" required autofocus name="nome" value="<?=$nome;?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Nome Fantasia</label>
                                            <input type="text" class="form-control" placeholder="Nome Fantasia" required autofocus name="nomefantasia" value="<?=$nomefantasia;?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Nome do Contato</label>
                                            <input type="text" class="form-control" placeholder="Nome do Contato" required autofocus name="nomecontato" value="<?=$nomecontato;?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">CNPJ</label>
                                            <input type="text" class="form-control" placeholder="CNPJ" required name="documento" value="<?=$documento;?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Endereço</label>
                                            <input type="text" class="form-control" placeholder="Endereço" required name="endereco" value="<?=$endereco;?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Cidade</label>
                                            <input type="text" class="form-control" placeholder="Cidade" required name="cidade" value="<?=$cidade;?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Estado</label>
                                            <select name="estado" class="form-control">
                                                <option value="AC" <?php if ($estado == 'AC') { echo 'selected="selected"'; } ?>>Acre</option>
                                                <option value="AL" <?php if ($estado == 'AL') { echo 'selected="selected"'; } ?>>Alagoas</option>
                                                <option value="AP" <?php if ($estado == 'AP') { echo 'selected="selected"'; } ?>>Amapá</option>
                                                <option value="AM" <?php if ($estado == 'AM') { echo 'selected="selected"'; } ?>>Amazonas</option>
                                                <option value="BA" <?php if ($estado == 'BA') { echo 'selected="selected"'; } ?>>Bahia</option>
                                                <option value="CE" <?php if ($estado == 'CE') { echo 'selected="selected"'; } ?>>Ceará</option>
                                                <option value="DF" <?php if ($estado == 'DF') { echo 'selected="selected"'; } ?>>Distrito Federal</option>
                                                <option value="ES" <?php if ($estado == 'ES') { echo 'selected="selected"'; } ?>>Espírito Santo</option>
                                                <option value="GO" <?php if ($estado == 'GO') { echo 'selected="selected"'; } ?>>Goiás</option>
                                                <option value="MA" <?php if ($estado == 'MA') { echo 'selected="selected"'; } ?>>Maranhão</option>
                                                <option value="MT" <?php if ($estado == 'MT') { echo 'selected="selected"'; } ?>>Mato Grosso</option>
                                                <option value="MS" <?php if ($estado == 'MS') { echo 'selected="selected"'; } ?>>Mato Grosso do Sul</option>
                                                <option value="MG" <?php if ($estado == 'MG') { echo 'selected="selected"'; } ?>>Minas Gerais</option>
                                                <option value="PA" <?php if ($estado == 'PA') { echo 'selected="selected"'; } ?>>Pará</option>
                                                <option value="PB" <?php if ($estado == 'PB') { echo 'selected="selected"'; } ?>>Paraíba</option>
                                                <option value="PR" <?php if ($estado == 'PR') { echo 'selected="selected"'; } ?>>Paraná</option>
                                                <option value="PE" <?php if ($estado == 'PE') { echo 'selected="selected"'; } ?>>Pernambuco</option>
                                                <option value="PI" <?php if ($estado == 'PI') { echo 'selected="selected"'; } ?>>Piauí</option>
                                                <option value="RJ" <?php if ($estado == 'RJ') { echo 'selected="selected"'; } ?>>Rio de Janeiro</option>
                                                <option value="RN" <?php if ($estado == 'RN') { echo 'selected="selected"'; } ?>>Rio Grande do Norte</option>
                                                <option value="RS" <?php if ($estado == 'RS') { echo 'selected="selected"'; } ?>>Rio Grande do Sul</option>
                                                <option value="RO" <?php if ($estado == 'RO') { echo 'selected="selected"'; } ?>>Rondônia</option>
                                                <option value="RR" <?php if ($estado == 'RR') { echo 'selected="selected"'; } ?>>Roraima</option>
                                                <option value="SC" <?php if ($estado == 'SC') { echo 'selected="selected"'; } ?>>Santa Catarina</option>
                                                <option value="SP" <?php if ($estado == 'SP') { echo 'selected="selected"'; } ?>>São Paulo</option>
                                                <option value="SE" <?php if ($estado == 'SE') { echo 'selected="selected"'; } ?>>Sergipe</option>
                                                <option value="TO" <?php if ($estado == 'TO') { echo 'selected="selected"'; } ?>>Tocantins</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Telefone</label>
                                            <input type="text" class="form-control" placeholder="Telefone" required name="telefone" value="<?=$telefone;?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Celular</label>
                                            <input type="text" class="form-control" placeholder="Celular" required name="celular" value="<?=$celular;?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">E-mail</label>
                                            <input type="text" class="form-control" placeholder="E-mail" required name="email" value="<?=$email;?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Senha</label>
                                            <input type="password" class="form-control" placeholder="Senha" required name="senha">
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-lg btn-primary btn-block" type="submit">Cadastrar</button>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('main/scripts'); ?>
    </body>
</html>