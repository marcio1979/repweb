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
                                                <span><?=$titulo;?> Fabricante</span>
                                                <div class="pull-right">
                                                    <a href="<?=base_url('fabricantes/listar');?>" onclick="redirect('<?=base_url('fabricantes/listar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> Voltar</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form id="frm" onsubmit="spinner(1);" method="POST" action="<?=$action;?>" class="form-horizontal">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nome</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="FabNome" name="FabNome" value="<?=$FabNome;?>" required>
                                                            <?php echo form_error('FabNome'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Ativo</label>
                                                        <div class="col-sm-5">
                                                            <select name="FabAtivo" id="FabAtivo" class="form-control">
                                                                <option value="1" <?php if ($FabAtivo == '1') { echo 'selected="selected"'; } ?>>Sim</option>
                                                                <option value="0" <?php if ($FabAtivo == '0') { echo 'selected="selected"'; } ?>>Não</option>
                                                            </select>
                                                            <?php echo form_error('FabAtivo'); ?>
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