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
									<span>Pesquisar Produtos</span>
									<div class="pull-right">
                                        <a href="<?=base_url("produtos/cadastrar");?>" onclick="redirect('<?=base_url("produtos/cadastrar");?>');" class="btn btn-xs btn-success"><i class="<?=$this->config->item('icon-cadastrar');?>"></i> cadastrar</a>
                                    </div>
								</div>
							</div>
							<div class="panel-body">
								<form id="frm" onsubmit="spinner(1);" method="GET" action="<?=base_url('produtos/listar');?>" class="form-horizontal">
									<fieldset>
									    <div class="form-row">
                                            <div class="col-sm-2">
                                                <label>Cód.</label>
                                                <input maxlength="100" type="text" class="form-control" size="50" id="ProdCodigoInterno" name="ProdCodigoInterno" value="<?=$ProdCodigoInterno;?>" />
                                                <?php echo form_error('ProdCodigoInterno'); ?>
                                            </div>
                                            <div class="col-sm-5">
                                                <label>Nome</label>
                                                <input maxlength="100" type="text" class="form-control" size="50" id="ProdNome" name="ProdNome" value="<?=$ProdNome;?>" />
                                                <?php echo form_error('ProdNome'); ?>
                                            </div>
                                            <div class="col-sm-5">
                                                <label>Fornecedor</label>
                                                <?=GeraSelect('ForCod', 'ForCod', 'ForNome', $ForCod, 'select * from fornecedores Where ForExcluido = 0 And ForAtivo = 1 Order by ForNome Asc');?>                                                <?php echo form_error('ForCod'); ?>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-sm-4">
                                                <label>Fabricante</label>
                                                <?=GeraSelect('FabCod', 'FabCod', 'FabNome', $FabCod, 'select * from fabricantes Where FabExcluido = 0 And FabAtivo = 1 Order by FabNome Asc');?>
                                                <?php echo form_error('FabCod'); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Grupo</label>
                                                <?=GeraSelect('PGCod', 'PGCod', 'PGNome', $PGCod, 'select * from produtosgrupos Where PGExcluido = 0 And PGAtivo = 1 Order by PGNome Asc');?>
                                                <?php echo form_error('PGCod'); ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>Ativo</label>
                                                <select name="ProdAtivo" id="ProdAtivo" class="form-control">
                                                    <?php $selected = 'selected="selected"'; ?>
                                                    <option value="1" <?php if ($ProdAtivo == '1') {echo $selected; } ?>>Sim</option>
                                                    <option value="0" <?php if ($ProdAtivo == '0') {echo $selected; } ?>>Não</option>
                                                    <option value="2" <?php if ($ProdAtivo != '1' && $ProdAtivo != '0') { echo $selected; } ?>>Todos</option>
                                                </select>
                                                <?php echo form_error('ProdAtivo'); ?>
                                            </div>
                                        </div>
									</fieldset>
									<div class="form-group">
									    <div class="col-sm-6">
										  <button type="submit" class="btn btn-primary">pesquisar</button>
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
											        'ProdCodigoInterno' => 'Cód',
                                                    'ProdNome' => 'Nome',
                                                    'PGNome' => 'Grupo',
                                                    'ForNome' => 'Fornecedor',
                                                    'FabNome' => 'Fabricante',
                                                    'ProdValor' => 'Valor'
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
                                                    <th class="header <?=$sortClass;?>" onclick="javascript: redirect('<?=base_url("produtos/listar?ordem=" . $th . '&sort=' . $sort . $link); ?>');"><?=$label;?></th>
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
												<tr id="row<?=$linha->ProdCod;?>">
													<td><?=$linha->ProdCodigoInterno;?></td>
													<td><?=$linha->ProdNome;?></td>
													<td><?=$linha->PGNome;?></td>
													<td><?=$linha->ForNome;?></td>
													<td><?=$linha->FabNome;?></td>
													<td>R$<?=number_format($linha->ProdValor,2,',','.');?></td>
                                                    <td align="center" width="50">
                                                        <a href="<?=base_url('produtos/consultar/' . $linha->ProdCod);?>" onclick="redirect('<?=base_url('produtos/consultar/' . $linha->ProdCod);?>');" title="Consultar"><i class="<?=$this->config->item('icon-consultar');?>"></i></a>
                                                    </td>
                                                    <td align="center" width="50">
                                                        <a href="<?=base_url('produtos/alterar/' . $linha->ProdCod);?>" onclick="redirect('<?=base_url('produtos/alterar/' . $linha->ProdCod);?>');" title="Alterar"><i class="<?=$this->config->item('icon-alterar');?>"></i></a>
                                                    </td>
                                                    <td align="center" width="50">
                                                        <a href="javascript: void 0;" onclick="deleteRow('Tem certeza que deseja excluir o produto <?=$linha->ProdNome;?>?', '<?=base_url("produtos/apagar/" . $linha->ProdCod);?>');"><i class="<?=$this->config->item('icon-excluir');?>"></i></a>
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
