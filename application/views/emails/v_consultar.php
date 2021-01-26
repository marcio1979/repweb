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
                                                <span>Consultar E-mail</span>
                                                <div class="pull-right">
                                                    <a href="<?=base_url('emails/listar');?>" onclick="redirect('<?=base_url('emails/listar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> voltar</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Título do E-mail</label>
                                                    <div class="col-sm-5">
                                                        <?=$EmaTitulo;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Tipo do E-mail</label>
                                                    <div class="col-sm-5">
                                                        <?=$EmaTipo;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Texto do E-mail</label>
                                                    <div class="col-sm-5">
                                                        <?=nl2br($EmaTexto);?>
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