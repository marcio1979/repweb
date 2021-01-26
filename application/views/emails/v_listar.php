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
									<span>Pesquisar E-mails</span>
								</div>
							</div>
							<div class="panel-body">
								<form id="frm" onsubmit="spinner(1);" method="GET" action="<?=base_url('emails/listar');?>" class="form-horizontal">
									<fieldset>
										<div class="form-group">
											<label class="col-sm-3 control-label">Título</label>
											<div class="col-sm-5">
												<input maxlength="100" type="text" class="form-control" size="50" id="EmaTitulo" name="EmaTitulo" value="<?=$EmaTitulo;?>" />
												<?php echo form_error('EmaTitulo'); ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Tipo</label>
											<div class="col-sm-5">
												<select name="EmaTipo" id="EmaTipo" class="form-control">
													<?php $selected = 'selected="selected"'; ?>
													<option value="Cadastro Aprovado" <?php if ($EmaTipo == 'Cadastro Aprovado') {echo $selected; } ?>>Cadastro Aprovado</option>
													<option value="Novo Cadastro" <?php if ($EmaTipo == 'Novo Cadastro') {echo $selected; } ?>>Novo Cadastro</option>
													<option value="Novo Pedido" <?php if ($EmaTipo == 'Novo Pedido') {echo $selected; } ?>>Novo Pedido</option>
													<option value="Alteração de Senha" <?php if ($EmaTipo == 'Alteração de Senha') {echo $selected; } ?>>Alteração de Senha</option>
													<option value="" <?php if ($EmaTipo == '') { echo $selected; } ?>>Todos</option>
												</select>
												<?php echo form_error('EmaTipo'); ?>
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
                                                    'PGCod' => "#",
                                                    'EmaTitulo' => 'Título do E-mail',
                                                    'EmaTipo' => 'Tipo do E-mail'
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
                                                    <th class="header <?=$sortClass;?>" onclick="javascript: redirect('<?=base_url("emails/listar?ordem=" . $th . '&sort=' . $sort . $link); ?>');"><?=$label;?></th>
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
												<tr id="row<?=$linha->EmaCod;?>">
													<td><?=$linha->EmaCod;?></td>
													<td><?=$linha->EmaTitulo;?></td>
													<td><?=$linha->EmaTipo;?></td>
													<td align="center" width="50">
                                                        <a href="<?=base_url('emails/consultar/' . $linha->EmaCod);?>" onclick="redirect('<?=base_url('emails/consultar/' . $linha->EmaCod);?>');" title="Consultar"><i class="<?=$this->config->item('icon-consultar');?>"></i></a>
                                                    </td>
                                                    <td align="center" width="50">
                                                        <a href="<?=base_url('emails/alterar/' . $linha->EmaCod);?>" onclick="redirect('<?=base_url('emails/alterar/' . $linha->EmaCod);?>');" title="Alterar"><i class="<?=$this->config->item('icon-alterar');?>"></i></a>
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
