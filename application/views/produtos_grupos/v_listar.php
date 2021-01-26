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
									<span>Pesquisar Grupos de Produtos</span>
									<div class="pull-right">
                                        <a href="<?=base_url('produtos-grupos/cadastrar');?>" onclick="redirect('<?=base_url("produtos-grupos/cadastrar");?>');" class="btn btn-xs btn-success"><i class="<?=$this->config->item('icon-cadastrar');?>"></i> cadastrar</a>
                                    </div>
								</div>
							</div>
							<div class="panel-body">
								<form id="frm" onsubmit="spinner(1);" method="GET" action="<?=base_url('produtos-grupos/listar');?>" class="form-horizontal">
									<fieldset>
										<div class="form-group">
											<label class="col-sm-3 control-label">Código</label>
											<div class="col-sm-5">
												<input maxlength="100" type="text" class="form-control" size="50" id="PGCod" name="PGCod" value="<?=$PGCod;?>" />
												<?php echo form_error('PGCod'); ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Nome</label>
											<div class="col-sm-5">
												<input maxlength="100" type="text" class="form-control" size="50" id="PGNome" name="PGNome" value="<?=$PGNome;?>" />
												<?php echo form_error('PGNome'); ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label">Ativo</label>
											<div class="col-sm-5">
												<select name="PGAtivo" id="PGAtivo" class="form-control">
													<?php $selected = 'selected="selected"'; ?>
													<option value="1" <?php if ($PGAtivo == '1') {echo $selected; } ?>>Sim</option>
													<option value="0" <?php if ($PGAtivo == '0') {echo $selected; } ?>>Não</option>
													<option value="2" <?php if ($PGAtivo != '1' && $PGAtivo != '0') { echo $selected; } ?>>Todos</option>
												</select>
												<?php echo form_error('PGAtivo'); ?>
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
                                                    'PGNome' => 'Nome'
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
                                                    <th class="header <?=$sortClass;?>" onclick="javascript: redirect('<?=base_url("produtos-grupos/listar?ordem=" . $th . '&sort=' . $sort . $link); ?>');"><?=$label;?></th>
                                                <?php 
											    }
                                                ?>
                                                <th style="text-align: center;">Consultar</th>
                                                <th style="text-align: center;">Alterar</th>
												<th style="text-align: center;">Excluir</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach ($dados as $dado => $linha) {
											?>
												<tr id="row<?=$linha->PGCod;?>">
													<td><?=$linha->PGCod;?></td>
													<td><?=$linha->PGNome;?></td>
													<td align="center" width="50">
                                                        <a href="<?=base_url('produtos-grupos/consultar/' . $linha->PGCod);?>" onclick="redirect('<?=base_url('produtos-grupos/consultar/' . $linha->PGCod);?>');" title="Consultar"><i class="<?=$this->config->item('icon-consultar');?>"></i></a>
                                                    </td>
                                                    <td align="center" width="50">
                                                        <a href="<?=base_url('produtos-grupos/alterar/' . $linha->PGCod);?>" onclick="redirect('<?=base_url('produtos-grupos/alterar/' . $linha->PGCod);?>');" title="Alterar"><i class="<?=$this->config->item('icon-alterar');?>"></i></a>
                                                    </td>
                                                    <td align="center" width="50">
                                                        <a href="javascript: void 0;" onclick="deleteRow('Tem certeza que deseja excluir o grupo de produto <?=$linha->PGNome;?>?', '<?=base_url("produtos-grupos/apagar/" . $linha->PGCod);?>');"><i class="<?=$this->config->item('icon-excluir');?>"></i></a>
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
