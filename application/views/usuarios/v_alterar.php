<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php $this->load->view('main/headers'); ?>
    </head>
    <body>
        <div id="wrapper">
            <?php $this->load->view('main/navbar'); ?>
            <div id="page-wrapper">
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <?php
                                    if (isset($msg)) {
                                    ?>
                                        <div class="<?=$type;?>"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?=$msg;?></div>
                                    <?php
                                    }
                                    ?>
                                    <form id="frm" onsubmit="spinner(1);" method="POST" action="<?=$action;?>" class="form-horizontal">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <div class="box-name">
                                                    <i class="<?=$this->config->item('icon-alterar');?>"></i>
                                                    <span><?=$titulo;?> usuário</span>
                                                    <div class="pull-right">
                                                        <a href="<?=base_url('usuarios/listar');?>" onclick="redirect('<?=base_url('usuarios/listar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> voltar</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <fieldset>
                                                    <legend>Dados cadastrais</legend>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Razão Social</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuNome" name="UsuNome" value="<?=$UsuNome;?>" required>
                                                            <?php echo form_error('UsuNome'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nome Fantasia</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuNomeFantasia" name="UsuNomeFantasia" value="<?=$UsuNomeFantasia;?>" required>
                                                            <?php echo form_error('UsuNomeFantasia'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nome do Contato</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuNomeContato" name="UsuNomeContato" value="<?=$UsuNomeContato;?>" required>
                                                            <?php echo form_error('UsuNomeContato'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Documento</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuDocumento" name="UsuDocumento" value="<?=$UsuDocumento;?>" required>
                                                            <?php echo form_error('UsuDocumento'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Endereço</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuEndereco" name="UsuEndereco" value="<?=$UsuEndereco;?>" required>
                                                            <?php echo form_error('UsuEndereco'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Cidade</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuCidade" name="UsuCidade" value="<?=$UsuCidade;?>" required>
                                                            <?php echo form_error('UsuCidade'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Estado</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuEstado" name="UsuEstado" value="<?=$UsuEstado;?>" required>
                                                            <?php echo form_error('UsuEstado'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Telefone</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuTelefone" name="UsuTelefone" value="<?=$UsuTelefone;?>" required>
                                                            <?php echo form_error('UsuTelefone'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Celular</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuCelular" name="UsuCelular" value="<?=$UsuCelular;?>" required>
                                                            <?php echo form_error('UsuCelular'); ?>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <br />
                                                <fieldset>
                                                    <legend>Dados de acesso</legend>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">E-mail</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="UsuEmail" name="UsuEmail" value="<?=$UsuEmail;?>" required>
                                                            <?php echo form_error('UsuEmail'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Senha</label>
                                                        <div class="col-sm-5">
                                                            <span style="font-size: 9px;">(deixe em branco para não alterar)</span><br />
                                                            <input maxlength="100" type="password" class="form-control" size="50" id="UsuSenha" name="UsuSenha" value="">
                                                            <?php echo form_error('UsuSenha'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Usuário master?</label>
                                                        <div class="col-sm-5">
                                                            <select name="UsuMaster" id="UsuMaster" class="form-control">
                                                                <option value="1" <?php if ($UsuMaster == '1') { echo 'selected="selected"'; } ?>>Sim</option>
                                                                <option value="0" <?php if ($UsuMaster == '0') { echo 'selected="selected"'; } ?>>Não</option>
                                                            </select>
                                                            <?php echo form_error('UsuMaster'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Status</label>
                                                        <div class="col-sm-5">
                                                            <select name="UsuStatus" id="UsuStatus" class="form-control">
                                                                <option value="1" <?php if ($UsuStatus == '1') { echo 'selected="selected"'; } ?>>Ativo</option>
                                                                <option value="0" <?php if ($UsuStatus == '0') { echo 'selected="selected"'; } ?>>Aguardando Aprovação</option>
                                                                <option value="2" <?php if ($UsuStatus == '2') { echo 'selected="selected"'; } ?>>Recusado</option>
                                                            </select>
                                                            <?php echo form_error('UsuAtivo'); ?>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <div class="box-name">
                                                    <i class="<?=$this->config->item('icon-alterar');?>"></i>
                                                    <span>Fornecedores</span>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Fornecedor</th>
                                                            <th>Condição Pagamento</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if (count($fornecedores) > 0) {
                                                            foreach ($fornecedores as $fornecedor => $row) {
                                                                if (array_key_exists($row->ForCod, $ForCod)) {
                                                                    $checked = 'checked="checked"';
                                                                } else {
                                                                    $checked = '';
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td><input type="checkbox" name="fornecedores[]" value="<?=$row->ForCod;?>" <?=$checked;?>/></td>
                                                                    <td><?=$row->ForNome;?></td>
                                                                    <td><input type="text" name="UFCondicaoPagamento<?=$row->ForCod;?>" value="<?php if(isset($ForCod[$row->ForCod])) { echo $ForCod[$row->ForCod]; } ?>" /></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="form-group">
                                                    <div class="col-sm-9 col-sm-offset-3">
                                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <?php $this->load->view('main/scripts'); ?>
    </body>
</html>