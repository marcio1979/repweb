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
                                                <span><?=$titulo;?> E-mails</span>
                                                <div class="pull-right">
                                                    <a href="<?=base_url('emails/listar');?>" onclick="redirect('<?=base_url('emails/listar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> voltar</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form id="frm" onsubmit="spinner(1);" method="POST" action="<?=$action;?>" class="form-horizontal">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Tipo do E-mail</label>
                                                        <div class="col-sm-5">
                                                            <?=$EmaTipo;?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Título do E-mail</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="EmaTitulo" name="EmaTitulo" value="<?=$EmaTitulo;?>" required>
                                                            <?php echo form_error('EmaTitulo'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Texto do E-mail</label>
                                                        <div class="col-sm-5">
                                                            <textarea class="form-control" id="EmaTexto" style="width: 100%; height: 300px; padding: 0 !important;" name="EmaTexto"><?=$EmaTexto;?></textarea>
                                                            <?php echo form_error('EmaTexto'); ?>
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
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="box-name">
                                                <i class="<?=$this->config->item('icon-alterar');?>"></i>
                                                <span>Legenda</span>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            {NomeUsuario} = Nome do usuário que receberá o e-mail. <br />
                                            {Link} = Link que será recebido no e-mail (novo cadastro, novo pedido, alteração de senha ou tela de login).
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