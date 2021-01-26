<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php $this->load->view('main/headers'); ?>
    </head>
    <style>
        th, td{ padding: 0 !important; margin: 0 !important;} 
        .qtd { height: 18px; width: 50px; }
        .form-group { padding: 0 !important; margin-top: 5px !important; }
        .modal-dialog { width: max-content; }
    </style>
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
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="frm" onsubmit="spinner(1);" method="GET" action="<?=base_url('pedidos/produtos/' . $PedCod);?>">
                                    <fieldset>
                                        <div class="form-row">
                                            <div class="col-sm-6">
                                                <input style="<?php if ($ProdNome != '') { echo 'background-color: #fbdfc8;'; } ?>" onkeypress="enter(event);" maxlength="100" type="text" class="form-control" size="50" id="ProdNome" name="ProdNome" value="<?=$ProdNome;?>" placeholder="Nome do produto" />
                                                <?php echo form_error('ProdNome'); ?>
                                            </div>
                                            <div class="col-sm-6" style="margin-bottom: 5px;">
                                                <input style="<?php if ($ProdCodigoInterno != '') { echo 'background-color: #fbdfc8;'; } ?>" onkeypress="enter(event);" maxlength="100" type="text" class="form-control" size="50" id="ProdCodigoInterno" name="ProdCodigoInterno" value="<?=$ProdCodigoInterno;?>" placeholder="Código do produto" />
                                                <?php echo form_error('ProdCodigoInterno'); ?>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-sm-6">
                                                <?=GeraSelect('FabCod', 'FabCod', 'FabNome', $FabCod, "Select * From fabricantes Where FabExcluido = 0 And FabAtivo = 1 And Exists (Select ProdCod From produtos Where produtos.FabCod = fabricantes.FabCod And produtos.ForCod = '".$ForCod."') Order by FabNome Asc");?>
                                                <?php echo form_error('FabCod'); ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php
                                                $filtroFab = "";
                                                if ($FabCod != '') {
                                                    $filtroFab = " And produtos.FabCod = '".$FabCod."'";
                                                }
                                                ?>
                                                <?=GeraSelect('PGCod', 'PGCod', 'PGNome', $PGCod, "Select * From produtosgrupos Where PGExcluido = 0 And PGAtivo = 1 And Exists (Select ProdCod From produtos Where produtos.PGCod = produtosgrupos.PGCod And produtos.ForCod = '".$ForCod."' ".$filtroFab.") Order by PGNome Asc");?>
                                                <?php echo form_error('produtos.PGCod'); ?>
                                            </div>
                                        </div>
                                    </fieldset>
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
                                    <?='<span id="qtRows">' . $total . '</span> produtos encontrados';?>
                                    <div class="pull-right" style="margin-top: -5px;">
                                        <a href="<?=base_url('pedidos/processar/'.$PedCod);?>" onclick="redirect('<?=base_url('pedidos/processar/'.$PedCod);?>');" class="btn btn-sm btn-success"><i class="<?=$this->config->item('icon-voltar');?>"></i> Resumo do Pedido</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if (count($dados) > 0) {
                            ?>
                                <div class="panel-body">
                                    <div class="produtos">
                                        <table id="listaProdutos" border="0" class="table table-bordered table-striped table-hover table-heading table-datatable">
                                            <thead>
                                                <tr>
                                                    <th>Cód</th>
                                                    <th>Produto</th>
                                                    <th>Grupo</th>
                                                    <th>Fabricante</th>
                                                    <th></th>
                                                    <th>Unitário</th>
                                                    <th>Qtd</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($dados as $dado => $linha) {
                                                    if (isset($pedidosItens[$linha->ProdCod])) {
                                                        $Quantidade = $pedidosItens[$linha->ProdCod];
                                                        $totalProduto = ($Quantidade*$linha->ProdValor);
                                                    } else {
                                                         $Quantidade = '';
                                                         $totalProduto = '0.00';
                                                    }
                                                    ?>
                                                    <tr id="item<?=$linha->ProdCod;?>" <?php if ($Quantidade > 0) { ?>style="background-color: #CCC;" <?php } ?>>
                                                        <td><?=$linha->ProdCodigoInterno;?></td>
                                                        <td>
                                                            <?=$linha->ProdNome;?> 
                                                            <?php if ($linha->ProdMarcador != '') { ?> <span class="label label-<?=$linha->ProdTipoMarcador;?>"><?=$linha->ProdMarcador;?></span> <?php } ?>
                                                        </td>
                                                        <td><?=$linha->PGNome;?></td>
                                                        <td><?=$linha->FabNome;?></td>
                                                        <td>
                                                            <?php 
                                                            if ($linha->ProdFoto != '') {
                                                            ?>
                                                                <a class="fotoModal" href="javascript: void 0;">
                                                                    <i class="fa fa-camera" style="margin-right: 5px;"></i>
                                                                    <img src="<?=base_url('upload/fotos/'.$linha->ProdFoto);?>" class="hide">
                                                                </a>
                                                            <?php
                                                            }
                                                            if ($linha->ProdDescricao != '') { 
                                                            ?>
                                                                <i data-toggle="tooltip" data-placement="top" title="<?=$linha->ProdDescricao;?>" style="color: #FFC107;;" class="fa fa-info-circle"></i>
                                                            <?php 
                                                            } 
                                                            ?>
                                                        </td>
                                                        <td>R$<?=number_format($linha->ProdValor,2,',','.');?></td>
                                                        <td><input onblur="adicionaItem('<?=$linha->ProdCod;?>');" type="text" id="PIQuantidade<?=$linha->ProdCod;?>" class="qtd" value="<?=$Quantidade;?>"></td>
                                                        <td align="center" id="total<?=$linha->ProdCod;?>">R$<?=number_format($totalProduto,2,',','.');?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>    
                                    </div>
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
        <?php $this->load->view('main/scripts'); ?>
        <script>
            $(function() {
                $('.fotoModal').on('click', function() {
                    $('#imagepreview').attr('src', $(this).find('img').attr('src'));
                    $('#imagemodal').on('show.bs.modal', function () {
                       $(this).find('img').css('max-width',$( window ).width()*0.5);
                       $(this).find('img').css('max-height',$( window ).height()*0.5);
                    });
                    $('#imagemodal').modal('show');
                });
            });
            
            function adicionaItem (ProdCod) {
                
                $('#total'+ProdCod).html('<img src="<?=base_url('images/loading.gif');?>" style="height: 15px;" />');
                var qtd = $('#PIQuantidade' + ProdCod).val();
                
                $.ajax({
                    url: '<?=base_url("pedidos/pedidoItem");?>/' + '<?=$PedCod;?>/' + ProdCod + '/' + qtd,
                    type: 'GET',
                    dataType: 'json', 
                    success: function(data) {
                        if (data.error != '') { 
                            alert(data.error);
                        } else {
                            $('#total'+ProdCod).html(data.total);
                        }
                        
                        if (qtd <= 0) {
                            displayAlert('<div class="alert alert-success">Produto excluido com sucesso!</div>');
                            $('#item'+ProdCod).css('background-color', '');
                        } else {
                            displayAlert('<div class="alert alert-success">Produto atualizado com sucesso!</div>');
                            $('#item'+ProdCod).css('background-color', '#CCC');
                        }
                    }
                });
            }
            
            function enter(event){
                var tecla = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
                if (tecla==13) {
                    $('#frm').submit();
                }
            }
            
            $(function() { 
                $('#FabCod option:contains("Selecione uma opção")').text('Selecione um fabricante');
                $('#PGCod option:contains("Selecione uma opção")').text('Selecione um grupo');
                
                $('#PGCod').change(function() {
                    $('#frm').submit();
                });
                $('#FabCod').change(function() {
                    $('#frm').submit();
                });
                
                <?php
                if ($PGCod != '') {
                ?>
                     $('#PGCod').css('background-color','#fbdfc8');
                <?php
                }
                ?>
                <?php
                if ($FabCod != '') {
                ?>
                     $('#FabCod').css('background-color','#fbdfc8');
                <?php
                }
                ?>
            });
            $(document).ready(function() {
                $("#wrapper").toggleClass("toggled");
            });
        </script>
    </body>
</html>
