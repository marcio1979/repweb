<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php $this->load->view('main/headers'); ?>
    </head>
    <body>
        <div class="modal fade" id="confirmModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Confirmar <span id="confirmTitle"></span>?</h4>
                    </div>
                
                    <div class="modal-body">
                        <p id="confirmLabel"></p>
                        <p class="debug-url"></p>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                        <a class="btn btn-danger btn-ok" id="confirmPage" href="">Sim</a>
                    </div>
                </div>
            </div>
        </div>
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
                                    <span>Consultar Pedido</span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php
                                if ($total < $ForPedidoMinimo) {
                                ?>
                                    <div class="alert alert-danger">Não é possível finalizar esse pedido porque o valor total é inferior ao Pedido mínimo do fornecedor.</div>
                                <?php
                                }
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav active"><a href="#info" data-toggle="tab">Informações</a></li>
                                            <div class="pull-right">
                                                <?php
                                                if ($PSCod == 1 || $PSCod == 2) {
                                                ?>
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-basic btn-xs dropdown-toggle" data-toggle="dropdown">
                                                            <i class="fa fa-cog"></i> <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="javascript: void 0;" onclick="confirma('cancelamento', 'Tem certeza que deseja <strong>cancelar</strong> o pedido <?=$PedCod;?>?', '<?=base_url("pedidos/status/" . $PedCod . "/4");?>');"><i class="fa fa-times"></i> Cancelar</a></li>
                                                            <li><a href="javascript: void 0;" onclick="confirma('pendência', 'Tem certeza que deseja colocar o pedido <?=$PedCod;?> como <strong>pendente</strong>?', '<?=base_url("pedidos/status/" . $PedCod . "/2");?>');"><i class="fa fa-clock-o"></i> Pendente</a></li>
                                                            <?php
                                                            if ($total >= $ForPedidoMinimo) {
                                                            ?>
                                                                <li><a href="javascript: void 0;" onclick="confirma('finalização', 'Tem certeza que deseja <strong>finalizar</strong> o pedido <?=$PedCod;?>?', '<?=base_url("pedidos/status/" . $PedCod . "/3");?>');"><i class="fa fa-check"></i> Finalizar</a></li>
                                                            <?php
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <a href="<?=base_url('pedidos/listar');?>" onclick="redirect('<?=base_url('pedidos/listar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> Voltar</a>
                                                <a href="<?=base_url('pedidos/pdf/'.$PedCod);?>" target="_blank" class="btn btn-xs btn-danger"><i class="fa fa-file-pdf-o"></i> PDF</a>
                                            </div>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="info">
                                                <fieldset>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Código</label>
                                                        <div class="col-sm-5">
                                                            #<?=str_pad($PedCod, 8, "0", STR_PAD_LEFT);?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Fornecedor</label>
                                                        <div class="col-sm-5">
                                                            <?=$ForNome;?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Razão Social</label>
                                                        <div class="col-sm-5">
                                                            <?=$UsuNome;?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Nome Fantasia</label>
                                                        <div class="col-sm-5">
                                                            <?=$UsuNomeFantasia;?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Data</label>
                                                        <div class="col-sm-5">
                                                            <?=converteData($PedData);?>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Status</label>
                                                        <div class="col-sm-5">
                                                            <?=$PSNome;?>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($PedObservacao != '') {
                                                    ?>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Observação</label>
                                                            <div class="col-sm-5">
                                                                <?=$PedObservacao;?>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    
                                                    if ($PSCod == 1 || $PSCod == 2) {
                                                    ?>
                                                        <div class="form-group"><hr /></div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Condição de Pagamento</label>
                                                            <div class="col-sm-5">
                                                                <?=$UFCondicaoPagamento;?>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Pedido Mínimo</label>
                                                            <div class="col-sm-5">
                                                                R$<?=number_format($ForPedidoMinimo, 2, ',', '.');?>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 30px;">
                                    <div class="col-lg-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav active"><a href="#produtos" data-toggle="tab">Produtos</a></li>
                                            <?php
                                            if ($PSCod == 1 || $PSCod == 2) {
                                            ?>
                                                <div class="pull-right" style="margin-top: -5px;">
                                                    <a href="<?=base_url('pedidos/produtos/'.$PedCod);?>" onclick="redirect('<?=base_url('pedidos/produtos/'.$PedCod);?>');"  class="btn btn-sm btn-primary"><i class="fa fa-copy"></i> EDITAR PRODUTOS</a>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="produtos">
                                                <fieldset>
                                                    <?php
                                                    if (count($itens) > 0) {
                                                    ?>
                                                        <div class="panel-body table-responsive">
                                                            <table border="0" class="table table-striped table-hover table-heading table-datatable">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Cód</th>
                                                                        <th>Produto</th>
                                                                        <th>Fabricante</th>
                                                                        <th>Qtd</th>
                                                                        <th>Unitário</th>
                                                                        <th>Total</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $total = 0;
                                                                    $qtd = 0;
                                                                    foreach ($itens as $item => $produto) {
                                                                        $valor = $produto->PIQuantidade*$produto->PIValor;
                                                                        $qtd = $qtd+$produto->PIQuantidade;
                                                                        $total = $total+($produto->PIQuantidade*$produto->PIValor);
                                                                        ?>
                                                                        <tr>
                                                                            <td><?=$produto->ProdCodigoInterno;?></td>
                                                                            <td><?=$produto->ProdNome;?></td>
                                                                            <td><?=$produto->FabNome;?></td>
                                                                            <td><?=$produto->PIQuantidade;?></td>
                                                                            <td>R$<?=number_format($produto->PIValor,2,',','.');?></td>
                                                                            <td>R$<?=number_format($valor,2,',','.');?></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="3">TOTAL</td>
                                                                        <td><?=$qtd;?></td>
                                                                        <td></td>
                                                                        <td><strong><?='R$'.number_format($total,2,',','.');?></strong></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="alert alert-warning">Seu pedido não possui nenhum produto. Clique no botão <strong>Editar Produtos</strong> para adicionar.</div>
                                                    <?php
                                                    }
                                                    ?>
                                                </fieldset>
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
        <script>
            function confirma(title, label, pagina) {
                $("#confirmPage").attr('href', pagina);
                $("#confirmTitle").html(title);
                $("#confirmLabel").html(label);
                $("#confirmModal").modal('show');
            }
        </script>
    </body>
</html>