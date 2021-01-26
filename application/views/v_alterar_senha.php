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
                                    if (isset($error)) {
                                    ?>
                                        <div class="<?=$type;?>" role="alert">
                                            <?=$error;?>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="box-name">
                                                Alterar senha
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <form id="frm" onsubmit="spinner(1);" method="POST" action="<?=base_url('configuracoes/alterar-senha'); ?>" class="form-horizontal">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Senha atual</label>
                                                        <div class="col-sm-5">
                                                            <input type="password" class="form-control" id="oldPassword" size="50" name="oldPassword" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nova senha</label>
                                                        <div class="col-sm-5">
                                                            <input type="password" class="form-control" id="newPassword" size="50" name="newPassword" required />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Repetir nova senha</label>
                                                        <div class="col-sm-5">
                                                            <input type="password" class="form-control" id="confirmPassword" size="50" name="confirmPassword" required />
                                                        </div>
                                                    </div>
                                                </fieldset>
                                                <div class="form-group">
                                                    <div class="col-sm-9 col-sm-offset-3">
                                                        <button type="submit" class="btn btn-primary">Alterar</button>
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
