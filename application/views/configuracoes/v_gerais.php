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
												<span>Alterar configurações gerais</span>
											</div>
										</div>
										<div class="panel-body">
											<form id="frm" onsubmit="spinner(1);" method="POST" enctype="multipart/form-data" action="<?=base_url('configuracoes/gerais');?>" class="form-horizontal">
												<fieldset>
													<div class="form-group">
                                                        <label class="col-sm-3 control-label">Nome da empresa</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="CfgNomeEmpresa" name="CfgNomeEmpresa" value="<?=$CfgNomeEmpresa;?>" required>
                                                            <?php echo form_error('CfgNomeEmpresa'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Telefone</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="CfgTelefone" name="CfgTelefone" value="<?=$CfgTelefone;?>" required>
                                                            <?php echo form_error('CfgTelefone'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">E-mail</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="CfgEmail" name="CfgEmail" value="<?=$CfgEmail;?>" required>
                                                            <?php echo form_error('CfgEmail'); ?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Endereço</label>
                                                        <div class="col-sm-5">
                                                            <input maxlength="100" type="text" class="form-control" size="50" id="CfgEndereco" name="CfgEndereco" value="<?=$CfgEndereco;?>" required>
                                                            <?php echo form_error('CfgEndereco'); ?>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <?php
                                                    if ($CfgLogo != '') {
                                                    ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Logotipo atual</label>
                                                            <div class="col-sm-5">
                                                                <img src="<?=base_url('upload/fotos/'.$CfgLogo);?>" style="max-width: 100%;" />
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Logotipo</label>
                                                        <div class="col-sm-5">
                                                            <span style="font-size:9;">(deixe em branco para não alterar)</span>
                                                            <input maxlength="100" type="file" class="form-control" size="50" id="CfgLogo" name="CfgLogo">
                                                            <?php echo form_error('CfgLogo'); ?>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <?php
                                                    if ($CfgFavicon != '') {
                                                    ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Favicon atual</label>
                                                            <div class="col-sm-5">
                                                                <img src="<?=base_url('upload/fotos/'.$CfgFavicon);?>" style="max-width: 100%;" />
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Favicon</label>
                                                        <div class="col-sm-5">
                                                            <span style="font-size:9;">(deixe em branco para não alterar)</span>
                                                            <input maxlength="100" type="file" class="form-control" size="50" id="CfgFavicon" name="CfgFavicon">
                                                            <?php echo form_error('CfgFavicon'); ?>
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