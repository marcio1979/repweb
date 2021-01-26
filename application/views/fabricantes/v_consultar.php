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
                                                <span>Consultar Fabricante</span>
                                                <div class="pull-right">
                                                    <a href="<?=base_url('fabricantes/listar');?>" onclick="redirect('<?=base_url('fabricantes/listar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> voltar</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Nome</label>
                                                    <div class="col-sm-5">
                                                        <?=$FabNome;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Ativo</label>
                                                    <div class="col-sm-5">
                                                        <?php 
                                                        if ($FabAtivo == 1) {
                                                             echo "Sim"; 
                                                        } else {
                                                            echo "Não";
                                                        } 
                                                        ?>
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
            </div>  
        </div>
        <?php $this->load->view('main/scripts'); ?>
    </body>
</html>