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
                <form id="frm" onsubmit="spinner(1);" enctype="multipart/form-data" method="POST" action="<?=$action;?>" class="form-horizontal">
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
                                                    <span><?=$titulo;?> Produto</span>
                                                    <div class="pull-right">
                                                        <a href="<?=base_url('produtos/listar');?>" onclick="redirect('<?=base_url('produtos/listar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> voltar</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nome</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="ProdNome" name="ProdNome" value="<?=$ProdNome;?>" required>
                                                            <?php echo form_error('ProdNome'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Fornecedor</label>
                                                        <div class="col-sm-5">
                                                            <?=GeraSelect('ForCod', 'ForCod', 'ForNome', $ForCod, 'Select * From fornecedores Where ForExcluido = 0 And ForAtivo = 1 Order by ForNome Asc');?>
                                                            <?php echo form_error('ForCod'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Fabricante</label>
                                                        <div class="col-sm-5">
                                                            <?=GeraSelect('FabCod', 'FabCod', 'FabNome', $FabCod, 'Select * From fabricantes Where FabExcluido = 0 And FabAtivo = 1 Order by FabNome Asc');?>
                                                            <?php echo form_error('FabCod'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Código de Referência</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="ProdCodigoInterno" name="ProdCodigoInterno" value="<?=$ProdCodigoInterno;?>" required>
                                                            <?php echo form_error('ProdCodigoInterno'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Preço de venda</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="ProdValor" name="ProdValor" value="<?=number_format((float)$ProdValor, 2, ',', '.');?>" required>
                                                            <?php echo form_error('ProdValor'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Descrição</label>
                                                        <div class="col-sm-5">
                                                            <textarea class="form-control" id="ProdDescricao" name="ProdDescricao"><?=$ProdDescricao;?></textarea>
                                                            <?php echo form_error('ProdDescricao'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Tipo Marcador</label>
                                                        <div class="col-sm-5">
                                                            <select name="ProdTipoMarcador" id="ProdTipoMarcador" class="form-control">
                                                                <option value="default" <?php if ($ProdTipoMarcador == 'default') { echo 'selected="selected"'; } ?>>Cinza</option>
                                                                <option value="primary" <?php if ($ProdTipoMarcador == 'primary') { echo 'selected="selected"'; } ?>>Azul</option>
                                                                <option value="success" <?php if ($ProdTipoMarcador == 'success') { echo 'selected="selected"'; } ?>>Verde</option>
                                                                <option value="info" <?php if ($ProdTipoMarcador == 'info') { echo 'selected="selected"'; } ?>>Azul Claro</option>
                                                                <option value="warning" <?php if ($ProdTipoMarcador == 'warning') { echo 'selected="selected"'; } ?>>Laranja</option>
                                                                <option value="danger" <?php if ($ProdTipoMarcador == 'danger') { echo 'selected="selected"'; } ?>>Vermelho</option>
                                                            </select>
                                                            <?php echo form_error('ProdDescricao'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Marcador</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="20" id="ProdMarcador" name="ProdMarcador" value="<?=$ProdMarcador;?>">
                                                            <?php echo form_error('ProdMarcador'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Grupo de Produto</label>
                                                        <div class="col-sm-5">
                                                            <?=GeraSelect('PGCod', 'PGCod', 'PGNome', $PGCod, 'Select * From produtosgrupos Where PGExcluido = 0 And PGAtivo = 1 Order by PGNome Asc');?>
                                                            <?php echo form_error('PGCod'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Ativo</label>
                                                        <div class="col-sm-5">
                                                            <select name="ProdAtivo" id="ProdAtivo" class="form-control">
                                                                <option value="1" <?php if ($ProdAtivo == '1') { echo 'selected="selected"'; } ?>>Sim</option>
                                                                <option value="0" <?php if ($ProdAtivo == '0') { echo 'selected="selected"'; } ?>>Não</option>
                                                            </select>
                                                            <?php echo form_error('ProdAtivo'); ?>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <?php
                                                    if ($ProdFoto != '') {
                                                    ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Excluir Imagem</label>
                                                            <div class="col-sm-5">
                                                                <select name="ProdFotoExcluir" id="ProdFotoExcluir" class="form-control">
                                                                    <option value="0" selected="selected">Não</option>
                                                                    <option value="1">Sim</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Foto atual</label>
                                                            <div class="col-sm-5">
                                                                <img src="<?=base_url('upload/fotos/'.$ProdFoto);?>" style="max-width: 100%;" />
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Foto</label>
                                                        <div class="col-sm-5">
                                                            <span style="font-size:9;">(deixe em branco para não alterar)</span>
                                                            <input maxlength="100" type="file" class="form-control" size="50" id="ProdFoto" name="ProdFoto">
                                                            <?php echo form_error('ProdFoto'); ?>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <button type="submit" class="btn btn-primary">salvar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>  
        </div>
        <?php $this->load->view('main/scripts'); ?>
    </body>
</html>