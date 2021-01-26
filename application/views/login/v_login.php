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
								<form class="form-signin" id="frmLogin" role="form" method="post" action="<?=base_url('login/login');?>">
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
										<label class="control-label">E-mail</label>
										<input type="text" class="form-control" id="email" placeholder="Email" required autofocus name="email">
									</div>
									<div class="form-group">
										<label class="control-label">Senha</label>
										<input type="password" class="form-control" placeholder="Senha" required name="senha">
								        <small><a href="#" onclick="esqueceuSenha();">Esqueceu a senha?</a></small>
									</div>
									<div class="text-center">
                                        <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
                                    </div>
                                    <div class="text-center">
                                        <br />
                                        <small>Ainda não tem acesso? Cadastre-se abaixo.</small>
                                        <a class="btn btn-lg btn-success btn-block" href="<?=base_url('login/cadastro');?>">Cadastrar</a>
                                    </div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php $this->load->view('main/scripts'); ?>
		<script>
		    function esqueceuSenha () {
		        var email = $('#email').val();
		        if (email == '') {
		            alert('Preencha o campo e-mail!');
		        } else {
		            $.ajax({
                      url: '<?=base_url('login/esqueceu-senha?email=');?>'+email,
                      success: function(data) {
                        alert(data);
                      }
                    });
		        }
		    }
		</script>
	</body>
</html>