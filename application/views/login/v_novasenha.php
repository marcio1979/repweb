<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php $this->load->view('main/headers'); ?>
    </head>
 	<body style="background-color: #FFF;">
 		<script>
			$(document).ready(function() { 
				$("#frmLogin").submit(function() { 
					$("#dialogWait").modal('show');
				});
			});
		</script>
 		<div id="dialogWait" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-backdrop="static">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h3>Aguarde...</h3>
					</div>
					<div class="modal-body">
						<div class="progress">
							<div class="progress-bar progress-bar-striped active2"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
								<span class="sr-only"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="wrapper">
			<div class="container-fluid">
				<div id="page-login" class="row">
					<div class="col-xs-12 col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-4">
						<div class="box">
							<div class="box-content">
								<br /><br /><br />
								<form class="form-signin" id="frmLogin" role="form" method="post" action="<?=base_url('login/nova-senha?chave='.$chave);?>">
									<div class="text-center">
										<h1 class="page-header" style="font-size: 38px !important;">
											<img src="<?=base_url('images/logo.png');?>" style="height: 50px;" />
										</h1>
									</div>
									<?php
									if (isset($error)) {
									?>
										<div class="<?=$type;?>" role="alert">
											<?=$error;?>
										</div>
									<?php
									}
									?>
									<div class="form-group">
                                        <label class="control-label">Nova Senha</label>
                                        <input type="password" class="form-control" placeholder="Nova Senha" required name="novasenha">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Repetir Nova Senha</label>
                                        <input type="password" class="form-control" placeholder="Repetir Nova Senha" required name="repetirnovasenha">
                                    </div>
									<div class="text-center">
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">Salvar</button>
                                    </div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('main/scripts'); ?>
	</body>
</html>