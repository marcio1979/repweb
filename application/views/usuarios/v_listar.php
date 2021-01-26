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
									<span>Pesquisar Usuários</span>
									<div class="pull-right">
                                        <a href="<?=base_url("usuarios/cadastrar");?>" onclick="redirect('<?=base_url("usuarios/cadastrar");?>');" class="btn btn-xs btn-success"><i class="<?=$this->config->item('icon-cadastrar');?>"></i> cadastrar</a>
                                    </div>
								</div>
							</div>
							<div class="panel-body">
								<form id="frm" onsubmit="spinner(1);" method="GET" action="<?=base_url('usuarios/listar');?>" class="form-horizontal">
									<fieldset>
										<div class="form-group">
											<label class="col-sm-3 control-label">Código</label>
											<div class="col-sm-5">
												<input maxlength="100" type="text" class="form-control" size="50" id="UsuCod" name="UsuCod" value="<?=$UsuCod;?>" />
												<?php echo form_error('UsuCod'); ?>
											</div>
										</div>
										<div class="form-group">
                                            <label class="col-sm-3 control-label">Nome</label>
                                            <div class="col-sm-5">
                                                <input maxlength="100" type="text" class="form-control" size="50" id="UsuNome" name="UsuNome" value="<?=$UsuNome;?>" />
                                                <?php echo form_error('UsuNome'); ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">E-mail</label>
                                            <div class="col-sm-5">
                                                <input maxlength="100" type="text" class="form-control" size="50" id="UsuEmail" name="UsuEmail" value="<?=$UsuEmail;?>" />
                                                <?php echo form_error('UsuEmail'); ?>
                                            </div>
                                        </div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Status</label>
											<div class="col-sm-5">
												<select name="UsuStatus" id="UsuStatus" class="form-control">
													<?php $selected = 'selected="selected"'; ?>
													<option value="1" <?php if ($UsuStatus == '1') {echo $selected; } ?>>Ativo</option>
													<option value="0" <?php if ($UsuStatus == '0') {echo $selected; } ?>>Aguardando Aprovação</option>
													<option value="2" <?php if ($UsuStatus == '2') {echo $selected; } ?>>Recusado</option>
													<option value="3" <?php if ($UsuStatus != '1' && $UsuStatus != '0' && $UsuStatus != '2') { echo $selected; } ?>>Todos</option>
												</select>
												<?php echo form_error('UsuStatus'); ?>
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
									<i class="fa fa-user"></i>
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
                                                    'UsuCod' => "#",
                                                    'UsuRazaoSocial' => 'Razão Social',
                                                    'UsuNomeFantasia' => 'Nome Fantasia',
                                                    'UsuCidade' => 'Cidade',
                                                    'UsuStatus' => 'Status'
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
                                                    <th class="header <?=$sortClass;?>" onclick="javascript: redirect('<?=base_url("usuarios/listar?ordem=" . $th . '&sort=' . $sort . $link); ?>');"><?=$label;?></th>
                                                <?php 
											    }
                                                ?>
                                                <th style="text-align: center;">Consultar</th>
                                                <th style="text-align: center;">Alterar</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($dados as $dado => $linha) {
											?>
												<tr id="row<?=$linha->UsuCod;?>">
													<td><?=$linha->UsuCod;?></td>
													<td><?=$linha->UsuNome;?></td>
													<td><?=$linha->UsuNomeFantasia;?></td>
													<td><?=$linha->UsuCidade . ' - ' . $linha->UsuEstado;?></td>
													<td>
													    <?php
													    if ($linha->UsuStatus == 0) {
													        echo "Aguardando Aprovação";
													    } elseif ($linha->UsuStatus == 1) {
													        echo "Ativo";
													    } elseif ($linha->UsuStatus == 2) {
													        echo '<span style="color: red;">Recusado</span>';
													    }
                                                        ?>
													</td>
													<td align="center" width="50">
                                                        <a href="<?=base_url('usuarios/consultar/' . $linha->UsuCod);?>" onclick="redirect('<?=base_url('usuarios/consultar/' . $linha->UsuCod);?>');" title="Alterar"><i class="<?=$this->config->item('icon-consultar');?>"></i></a>
                                                    </td>
                                                    <td align="center" width="50">
                                                        <a href="<?=base_url('usuarios/alterar/' . $linha->UsuCod);?>" onclick="redirect('<?=base_url('usuarios/alterar/' . $linha->UsuCod);?>');" title="Alterar"><i class="<?=$this->config->item('icon-alterar');?>"></i></a>
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
	</body>
</html>
