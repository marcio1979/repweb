<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php $this->load->view('main/headers'); ?>
        <style>
            .produtos { width: 100%; }
            .produto { font-size: 9px; float: left; margin-right: 10px; margin-bottom: 10px; height: 160px; border-bottom: solid 2px #EEE; width: 100px; text-align: center; }
            .foto { overflow: hidden; display: flex; justify-content: center; align-items: center; height: 100px; width: 100px;}
            .foto img { max-width: inherit; height: 170px; }
            .produto a { color: #000; }
            .modal-dialog{
                position: relative;
                display: table;
                overflow-y: auto;    
                overflow-x: auto;
                width: auto;
                min-width: 300px;
                margin: 0 auto; 
            }
            .modal-body { text-align: center; }
            th, td{ padding: 0 !important; margin: 0 !important;} 
            .qtd { height: 18px; width: 50px; }
            .selecione {
                background-color: #efeded;
                padding: 12px;
                color: #000000;
                font-weight: bold;
                font-size: 24px;
                display: none;
                position: absolute;
                width: 96%;
                height: 132px;
                opacity: 0.9;
                text-align: center;
                padding-top: 55px;
            }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <?php $this->load->view('main/navbar'); ?>
            <div id="page-wrapper">
                <br />
                <?php
                $finalizado = $this->session->flashdata('finalizado');
                if ($finalizado == 'finalizado') {
                    echo '<div class="alert alert-success">Seu pedido foi enviado com sucesso e em breve entraremos em contato. <br /> Selecione um fornecedor abaixo para iniciar um novo pedido!</div><br />';
                }
                ?>
                <?php
                $valorTotal = 0;
                $qtdTotal = 0;
                $totalProduto = 0;
                if (isset($pedido->ForCod)) {
                ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="box-name">
                                        <i class="<?=$this->config->item('icon-pesquisar');?>"></i>
                                        <span>Dados do Pedido</span>
                                        <div class="pull-right" style="margin-top: -5px;">
                                            <a href="#" onclick="finalizaPedido();" class="btn btn-sm btn-success" style="width: 180px;"><i class="fa fa-check"></i> ENVIAR PEDIDO</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="col-sm-5">
                                        <form id="frm" onsubmit="spinner(1);" method="GET" action="<?=base_url('pedidos/produtos');?>" class="form-horizontal">
                                            <table>
                                                <tr>
                                                    <th>Condição de Pagamento</th>
                                                    <td><?=$pedido->UFCondicaoPagamento; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Pedido Mínimo</th>
                                                    <td>R$<?=number_format($pedido->ForPedidoMinimo, 2, ',', '.');?></td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                    <div class="col-sm-7" style="text-align: right;">
                                        <?php
                                        if ($pedido->ForLogotipo != '') {
                                        ?>
                                            <p><img style="max-height: 65px; max-width: 100%;" src="<?=base_url('upload/fotos/'.$pedido->ForLogotipo);?>" /></p>
                                            <p><a class="btn btn-danger btn-sm" href="javascript: void 0;" onclick="trocaFornecedor();" style="width: 180px;"><i class="fa fa-refresh"></i> TROCAR FORNECEDOR</a></p>
                                        <?php
                                        } else {
                                            echo $pedido->ForNome;
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="box-name">
                                        <i class="<?=$this->config->item('icon-lista');?>"></i> Lista de Produtos
                                        <div class="pull-right" style="margin-top: -5px;">
                                            <a href="<?=base_url('pedidos/produtos/'.$pedido->PedCod);?>" onclick="redirect('<?=base_url('pedidos/produtos/'.$pedido->PedCod);?>');"  class="btn btn-sm btn-primary" style="width: 180px;"><i class="fa fa-copy"></i> ADICIONAR PRODUTOS</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="produtos">
                                        <div class="pull-left"><strong>Qtd Produtos:</strong> <span id="qtdTotal">0</span></div>
                                        <div class="pull-right"><strong>Valor Total:</strong> R$<span id="valorTotal">0,00</span></div>
                                        <table id="listaProdutos" border="0" class="table table-bordered table-striped table-hover table-heading table-datatable">
                                            <thead>
                                                <tr>
                                                    <th>Cód</th>
                                                    <th>Produto</th>
                                                    <th>Fabricante</th>
                                                    <th>Unitário</th>
                                                    <th>Qtd</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        <?php
                                        if (count($produtos) > 0) {
                                            foreach ($produtos as $produto => $dado) {
                                                $valorTotal = $valorTotal+($dado->PIQuantidade*$dado->PIValor);
                                                $qtdTotal = $qtdTotal+$dado->PIQuantidade;
                                                $totalProduto = ($dado->PIQuantidade*$dado->PIValor);
                                                ?>
                                                <tr id="tr<?=$dado->ProdCod;?>">
                                                    <td><?=$dado->ProdCodigoInterno;?></td>
                                                    <td><?=$dado->ProdNome;?></td>
                                                    <td><?=$dado->FabNome;?></td>
                                                    <td id="valor<?=$dado->ProdCod;?>">R$<?=number_format($dado->PIValor,2,',','.');?></td>
                                                    <td><input id="qtd<?=$dado->ProdCod;?>" class="qtd" type="text" value="<?=$dado->PIQuantidade;?>" onblur="alteraItem('<?=$dado->ProdCod;?>', this.value);" /></td>
                                                    <td align="center" id="total<?=$dado->ProdCod;?>" class="totalItem">R$<?=number_format($totalProduto,2,',','.');?></td>
                                                    <td><a href="javascript: void 0;" onclick="alteraItem('<?=$dado->ProdCod;?>', '');"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                        ?>
                                            <tr>
                                                <td colspan="7">
                                                    <br />
                                                    <div class="alert alert-warning" style="text-align: center;">Seu pedido não possui nenhum produto. Clique no botão acima para adicionar.</div>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="box-name">
                                        <i class="<?=$this->config->item('icon-pesquisar');?>"></i>
                                        <span>Selecione um Fornecedor</span>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <?php
                                    $isFornecedor = 0;
                                    if (is_array($fornecedores)) {
                                        if (count($fornecedores) > 0) {
                                            $isFornecedor = 1;
                                            foreach ($fornecedores as $fornecedor => $row) {
                                            ?>
                                                <div class="col-lg-4 col-sm-6">
                                                    <div class="panel panel-primary fornecedor">
                                                        <div class="selecione" style="cursor: pointer;" onmouseout="hideSelecione('<?=$row->ForCod;?>');" onclick="location.href='<?=base_url('pedidos/novo?ForCod=' . $row->ForCod);?>';" onmouseover="showSelecione('<?=$row->ForCod;?>');" id="selecione<?=$row->ForCod;?>">Clique e faça seu pedido!</div>
                                                        <div class="panel-body" style="text-align: center; word-wrap: break-word;">
                                                            <?php
                                                            if ($row->ForLogotipo != '') {
                                                            ?>
                                                                <p style="cursor: pointer;" onmouseout="hideSelecione('<?=$row->ForCod;?>');" onmouseover="showSelecione('<?=$row->ForCod;?>');" onclick="location.href='<?=base_url('pedidos/novo?ForCod=' . $row->ForCod);?>';"><img style="max-height: 150px; max-width: 100%;" src="<?=base_url('upload/fotos/'.$row->ForLogotipo);?>" /></p>
                                                            <?php
                                                            }
                                                            ?>
                                                            <p><?=$row->ForDescricao;?></p>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <strong>Condição de pagamento:</strong> <?=$row->UFCondicaoPagamento;?> <br />
                                                            <strong>Pedido Mínimo:</strong> R$<?=number_format($row->ForPedidoMinimo,2,',','.')?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        }
                                    }
                                    if($isFornecedor == 0){
                                        echo '<div class="alert alert-danger">Nenhum fornecedor foi liberado.</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>  
        </div>
        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                    </div>
                    <div class="modal-body">
                        <img src="" id="imagepreview">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmChange">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Trocar Fornecedor?</h4>
                    </div>
                
                    <div class="modal-body">
                        <p>Tem certeza que deseja trocar o fornecedor? Todos os produtos do seu pedido atual serão removidos.</p>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <a class="btn btn-danger btn-ok" onclick="spinner(1);" href="<?=base_url('pedidos/novo?ForCod=trocar');?>">TROCAR</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmFinish">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Finalizar Pedido</h4>
                    </div>
                
                    <div class="modal-body">
                        <p>Use o campo abaixo para fazer alguma observação em seu pedido e clique em Enviar.</p>
                        <p><textarea name="observacao" id="observacao" style="width: 100%;"></textarea></p>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <a class="btn btn-success btn-ok" onclick="enviarPedido();">ENVIAR</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog" id="flyermodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <img src="" id="flyerpreview">
                    </div>
                    <div class="modal-footer" style="text-align: center !important;">
                        <button type="button" class="btn btn-success" data-dismiss="modal">
                            Entendi
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('main/scripts'); ?>
        <script>
            $(function() {
                $('#valorTotal').html('<?=number_format($valorTotal,2, ',', '.');?>');
                $('#qtdTotal').html('<?=$qtdTotal;?>');    
            });
            
            function showSelecione (ForCod) {
                $('#selecione'+ForCod).show();
            }
            
            function hideSelecione (ForCod) {
                $('#selecione'+ForCod).hide();
            }
            
            <?php
            if ($pedido->ForFlyer != '') {
                if (!isset($_SESSION['ForFlyer'.$pedido->ForCod])) {
                ?>
                    $(function() {
                        $('#flyerpreview').attr('src', '<?=base_url('upload/fotos/'.$pedido->ForFlyer);?>');
                        $('#flyermodal').on('show.bs.modal', function () {
                           $(this).find('img').css('max-width',$( window ).width()*0.8);
                           $(this).find('img').css('max-height',$( window ).height()*0.8);
                        });
                        $('#flyermodal').modal('show');
                    });
                    <?php
                    $_SESSION['ForFlyer'.$pedido->ForCod] = 1;
                }
            }
            ?>
            
            <?php
            if (isset($pedido->ForCod)) {
            ?>
                function alteraItem (ProdCod, PIQuantidade) {
                    
                    $('#total'+ProdCod).html('<img src="<?=base_url('images/loading.gif');?>" style="height: 15px;" />');
                    $('#valorTotal').html('<img src="<?=base_url('images/loading.gif');?>" style="height: 15px;" />');
                    $('#qtdTotal').html('<img src="<?=base_url('images/loading.gif');?>" style="height: 15px;" />');
                    
                    $.ajax({
                        url: '<?=base_url("pedidos/pedidoItem");?>/' + '<?=$pedido->PedCod;?>/' + ProdCod + '/' + PIQuantidade,
                        type: 'GET',
                        dataType: 'json',
                        async: true,
                        success: function(data) {
                            if (data.error != '') { 
                                alert(data.error);
                            } else {
                                $('#total'+ProdCod).html(data.total);                            
                                if (PIQuantidade <= 0) {
                                    var par = $("#tr"+ProdCod);
                                    par.remove();
                                    displayAlert('<div class="alert alert-success">Produto excluido com sucesso!</div>');
                                } else {
                                    displayAlert('<div class="alert alert-success">Produto atualizado com sucesso!</div>');
                                }
                                atualizaTotal();
                            }
                        },
                        error: function() {
                            location.href='';
                        }
                    });
                }
                
                function atualizaTotal () {
                    
                    $('#valorTotal').html('<img src="<?=base_url('images/loading.gif');?>" style="height: 15px;" />');
                    var valorTotal = 0;
                    $('.totalItem').each(function() {
                        var o = $(this);
                        var valor = o.html().replace('R$', '').replace('.', '').replace(',', '.');
                        if (valor > 0) { valorTotal = parseFloat(valorTotal) + parseFloat(valor); }
                    });
                    $('#valorTotal').html(parseFloat(valorTotal).toFixed(2).replace('.', ','));
                    
                    $('#qtdTotal').html('<img src="<?=base_url('images/loading.gif');?>" style="height: 15px;" />');
                    var qtdTotal = 0;
                    $('.qtd').each(function() {
                        var i = $(this).val();
                        if (i > 0) { qtdTotal = parseInt(qtdTotal) + parseInt(i); }
                    });
                    $('#qtdTotal').html(qtdTotal);
                }
                
                function trocaFornecedor () {
                    var qtd = $('#qtdTotal').html();
                    if (qtd > 0) {
                        $('#confirmChange').modal();
                    } else {
                        spinner(1);
                        location.href='<?=base_url('pedidos/novo?ForCod=trocar');?>';
                    }
                }
                
                function finalizaPedido () {
                    $('#confirmFinish').modal();
                }
                
                function enviarPedido () {
                    spinner(1);
                    var valorTotal = parseFloat($('#valorTotal').html().replace('.', '').replace(',', '.')).toFixed(2);
                    var pedidoMinimo = parseFloat('<?=$pedido->ForPedidoMinimo;?>');
    
                    if (valorTotal < pedidoMinimo) {
                        alert('O valor total do seu pedido precisa respeitar o valor mínimo do fornecedor!');
                        spinner(0);
                    } else {
                        $.post("<?=base_url('pedidos/observacao');?>", {observacao: $('#observacao').val()});
                        location.href='<?=base_url('pedidos/finalizar');?>';
                    }
                }
            <?php
            }
            ?>
            
            $(document).ready(function() {
                $("#wrapper").toggleClass("toggled");
            });
        </script>
    </body>
</html>
