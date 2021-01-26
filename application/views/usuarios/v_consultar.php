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
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="box-name">
                                                <i class="<?=$this->config->item('icon-consultar');?>"></i>
                                                <span>Consultar usuário</span>
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
                                                        <?=$UsuNome;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Nome Fantasia</label>
                                                    <div class="col-sm-5">
                                                        <?=$UsuNomeFantasia;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Nome do Contato</label>
                                                    <div class="col-sm-5">
                                                        <?=$UsuNomeContato;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Documento</label>
                                                    <div class="col-sm-5">
                                                        <?=$UsuDocumento;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Endereço</label>
                                                    <div class="col-sm-5">
                                                        <?=$UsuEndereco;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Cidade</label>
                                                    <div class="col-sm-5">
                                                        <?=$UsuCidade;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Estado</label>
                                                    <div class="col-sm-5">
                                                        <?=$UsuEstado;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Telefone</label>
                                                    <div class="col-sm-5">
                                                        <?=$UsuTelefone;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Celular</label>
                                                    <div class="col-sm-5">
                                                        <?=$UsuCelular;?>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <br /><br />
                                            <fieldset>
                                                <legend>Dados de acesso</legend>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">E-mail</label>
                                                    <div class="col-sm-5">
                                                        <?=$UsuEmail;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Senha</label>
                                                    <div class="col-sm-5">
                                                        ********
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Usuário master?</label>
                                                    <div class="col-sm-5">
                                                        <?php
                                                        if ($UsuMaster == 1){
                                                            echo "sim";
                                                        } else {
                                                            echo "não";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Status</label>
                                                    <div class="col-sm-5">
                                                        <?php 
                                                        if ($UsuStatus == 1) {
                                                             echo "Ativo"; 
                                                        } elseif ($UsuStatus == 0) {
                                                            echo "Aguardando Aprovação";
                                                        } elseif ($UsuStatus == 2) {
                                                            echo "Recusado";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Data cadastro</label>
                                                    <div class="col-sm-5">
                                                        <?=converteData($UsuDataCadastro);?>
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
                                                                <td><input type="checkbox" disabled="disabled" name="fornecedores[]" value="<?=$row->ForCod;?>" <?=$checked;?>/></td>
                                                                <td><?=$row->ForNome;?></td>
                                                                <td><?php if(isset($ForCod[$row->ForCod])) { echo $ForCod[$row->ForCod]; } ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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