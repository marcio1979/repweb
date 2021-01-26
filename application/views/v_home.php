<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<?php $this->load->view('main/headers'); ?>
	</head>
	<body>
	    <div id="wrapper">
			<?php $this->load->view('main/navbar'); ?>
	        <div id="page-wrapper">
	        	<br /><br /><br />
				<div class="row">
					<div class="col-lg-12">
						<div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
								<div class="col-xs-12 col-sm-12">
									<div class="panel panel-info">
										<div class="panel-heading">
											<div class="box-name">
												<span>Seja Bem Vindo ao Representante WEB!</span>
											</div>
										</div>
										<div class="panel-body">
											<div style="float: left; text-align: center; margin-right: 80px;">
											    <a href="<?=base_url('pedidos');?>">
											        <div><img src="images/pedidos.png" style="height: 80px;" /></div>
    										        <div style="margin-top: 5px;">MEUS PEDIDOS</div>
										        </a>
										    </div>
											<div style="float: left; text-align: center;">
											    <a href="<?=base_url('pedidos/novo');?>">
    											   <div><img src="images/novo-pedido.png" style="height: 80px;" /></div>
    											   <div style="margin-top: 5px;">NOVO PEDIDO</div>
											    </a>
										    </div>
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
