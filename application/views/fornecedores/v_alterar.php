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
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="box-name">
                                                <i class="<?=$this->config->item('icon-alterar');?>"></i>
                                                <span><?=$titulo;?> Fornecedor</span>
                                                <div class="pull-right">
                                                    <a href="<?=base_url('fornecedores/listar');?>" onclick="redirect('<?=base_url('fornecedores/listar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> voltar</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form id="frm" onsubmit="spinner(1);" enctype="multipart/form-data" method="POST" action="<?=$action;?>" class="form-horizontal">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nome</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="ForNome" name="ForNome" value="<?=$ForNome;?>" required>
                                                            <?php echo form_error('ForNome'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Descrição</label>
                                                        <div class="col-sm-5">
                                                            <textarea class="form-control" id="ForDescricao" name="ForDescricao"><?=$ForDescricao;?></textarea>
                                                            <?php echo form_error('ForDescricao'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Pedido Mínimo</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="ForPedidoMinimo" name="ForPedidoMinimo" value="<?php if($ForPedidoMinimo != '') { echo number_format($ForPedidoMinimo,2,',','.'); } ?>" required>
                                                            <?php echo form_error('ForPedidoMinimo'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Ativo</label>
                                                        <div class="col-sm-5">
                                                            <select name="ForAtivo" id="ForAtivo" class="form-control">
                                                                <option value="1" <?php if ($ForAtivo == '1') { echo 'selected="selected"'; } ?>>Sim</option>
                                                                <option value="0" <?php if ($ForAtivo == '0') { echo 'selected="selected"'; } ?>>Não</option>
                                                            </select>
                                                            <?php echo form_error('ForAtivo'); ?>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <?php
                                                    if ($ForLogotipo != '') {
                                                    ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Excluir Imagem</label>
                                                            <div class="col-sm-5">
                                                                <select name="ForLogotipoExcluir" id="ForLogotipoExcluir" class="form-control">
                                                                    <option value="0" selected="selected">Não</option>
                                                                    <option value="1">Sim</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Logotipo atual</label>
                                                            <div class="col-sm-5">
                                                                <img src="<?=base_url('upload/fotos/'.$ForLogotipo);?>" style="max-width: 100%;" />
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Logotipo</label>
                                                        <div class="col-sm-5">
                                                            <span style="font-size:9;">(deixe em branco para não alterar)</span>
                                                            <input maxlength="100" type="file" class="form-control" size="50" id="ForLogotipo" name="ForLogotipo">
                                                            <?php echo form_error('ForLogotipo'); ?>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <?php
                                                    if ($ForFlyer != '') {
                                                    ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Excluir Imagem</label>
                                                            <div class="col-sm-5">
                                                                <select name="ForFlyerExcluir" id="ForFlyerExcluir" class="form-control">
                                                                    <option value="0" selected="selected">Não</option>
                                                                    <option value="1">Sim</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Flyer atual</label>
                                                            <div class="col-sm-5">
                                                                <img src="<?=base_url('upload/fotos/'.$ForFlyer);?>" style="max-width: 100%;" />
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Flyer</label>
                                                        <div class="col-sm-5">
                                                            <span style="font-size:9;">(deixe em branco para não alterar)</span>
                                                            <input maxlength="100" type="file" class="form-control" size="50" id="ForFlyer" name="ForFlyer">
                                                            <?php echo form_error('ForFlyer'); ?>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <div class="form-group">
                                                    <div class="col-sm-9 col-sm-offset-3">
                                                        <button type="submit" class="btn btn-primary">Salvar</button>
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
            </div>  
        </div>
        <?php $this->load->view('main/scripts'); ?>
    </body>
</html>