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
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="box-name">
									<i class="<?=$this->config->item('icon-pesquisar');?>"></i>
									<span>Pesquisar Pedidos</span>
								</div>
							</div>
							<div class="panel-body">
								<form id="frm" onsubmit="spinner(1);" method="GET" action="<?=base_url('pedidos/listar');?>" class="form-horizontal">
									<fieldset>
										<div class="form-group">
											<label class="col-sm-3 control-label">Código</label>
											<div class="col-sm-5">
												<input maxlength="100" type="text" class="form-control" size="50" id="PedCod" name="PedCod" value="<?=$PedCod;?>" />
												<?php echo form_error('PedCod'); ?>
											</div>
										</div>
										<div class="form-group">
                                            <label class="col-sm-3 control-label">Fornecedor</label>
                                            <div class="col-sm-5">
                                                <?=GeraSelect('ForCod', 'ForCod', 'ForNome', $ForCod, "Select * From fornecedores Where ForExcluido = 0 And ForAtivo = 1 AND EXISTS (Select usuarios_fornecedores.UsuCod FROM usuarios_fornecedores WHERE usuarios_fornecedores.ForCod = fornecedores.ForCod AND usuarios_fornecedores.UsuCod = '".$_SESSION['UsuCod']."') Order by ForNome Asc");?>
                                                <?php echo form_error('ForCod'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Status</label>
                                            <div class="col-sm-5">
                                                <?=GeraSelect('PSCod', 'PSCod', 'PSNome', $PSCod, 'Select * From pedidosstatus Order by PSNome Asc');?>
                                                <?php echo form_error('PSCod'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Data</label>
                                            <div class="col-sm-5">
                                                <input name="PedData" type="text" size="20" class="form-control" id="PedData" maxlength="10" value="<?=$PedData;?>" style="width: 155px; float: left;" />
                                                <?php echo form_error('PedCod'); ?>
                                            </div>
                                        </div>
									</fieldset>
									<div class="form-group">
										<div class="col-sm-9 col-sm-offset-3">
											<button type="submit" class="btn btn-primary">Pesquisar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
	            	<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="box-name">
									<i class="<?=$this->config->item('icon-lista');?>"></i>
									<?='<span id="qtRows">' . $total . '</span> registros encontrados';?>
								</div>
							</div>
							<?php
							if (count($dados) > 0) {
							?>
								<div class="panel-body table-responsive">
									<table border="0" class="table table-bordered table-striped table-hover table-heading table-datatable">
										<thead>
											<tr>
											    <?php
											    $headerTable = array(
                                                    'PedCod' => "#",
                                                    'UsuNome' => 'Razão Social',
                                                    'UsuNomeFantasia' => 'Nome Fantasia',
                                                    'ForNome' => 'Fornecedor',
                                                    'PSNome' => 'Status'
                                                );
											    foreach ($headerTable as $th => $label) {
											        $sortClass = '';
                                                    
                                                    if (!$sort) { $sort = "ASC"; }
                                                    
                                                    if ($ordem == $th && $sort == 'ASC') {
                                                        $sortClass = 'headerSortUp'; 
                                                        $sort = 'DESC'; 
                                                    } elseif ($ordem == $th && $sort == 'DESC') {
                                                        $sortClass = 'headerSortDown'; 
                                                        $sort = "ASC"; 
                                                    }
                                                    ?>
                                                    <th class="header <?=$sortClass;?>" onclick="javascript: redirect('<?=base_url("pedidos/listar?ordem=" . $th . '&sort=' . $sort . $link); ?>');"><?=$label;?></th>
                                                <?php 
											    }
                                                ?>
                                                <th style="text-align: center;">Processar</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($dados as $dado => $linha) {
											?>
												<tr id="row<?=$linha->PedCod;?>">
													<td><?=$linha->PedCod;?></td>
													<td><?=$linha->UsuNome;?></td>
													<td><?=$linha->UsuNomeFantasia;?></td>
													<td><?=$linha->ForNome;?></td>
													<td><?=$linha->PSNome;?></td>
													<td align="center" width="50">
                                                        <a href="<?=base_url('pedidos/processar/' . $linha->PedCod);?>" onclick="redirect('<?=base_url('pedidos/processar/' . $linha->PedCod);?>');" title="Processar"><i class="<?=$this->config->item('icon-consultar');?>"></i></a>
                                                    </td>
												</tr>
											<?php
											}
											?>
										</tbody>
									</table>
									<?=$paginacao;?>
								</div>
                            <?php
							}
							?>
						</div>
					</div>
				</div>
	        </div>	
	    </div>
	    <?php $this->load->view('main/scripts'); ?>
	    <script>
            $(function() {
                $("#PedData").datepicker({
                    dateFormat: 'dd/mm/yy',
                    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                    monthNames: ['Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                    nextText: 'Próximo',
                    prevText: 'Anterior',
                    showOn: "button",
                    changeMonth: true,
                    changeYear: true,
                    buttonText: '<i class="fa fa-calendar"></i>',
                }).next(".ui-datepicker-trigger").addClass("btn btn-gd");
            });
        </script>
	</body>
</html>
