<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php $this->load->view('main/headers'); ?>
    </head>
    <body>
        <div>
            <div class="col-lg-12">
                <?php /*
                <div class="row">
                    <img src="<?=base_url('images/logo.png');?>" style="width: 200px; vertical-align: top; float: left;" /> 
                    <div style="float: left;">
                        Representante WEB <br />
                        São José do Rio Preto - SP <br />
                        www.representanteweb.com.br
                    </div>
                </div> */ ?>
                <div class="row" style="margin-top: 30px;">
                    <div style="font-weight: bold; border-bottom: solid 1px #CCC;">Pedido</div>
                    <div style="margin-top: 10px;">
                        <table border="0">
                            <tbody>
                                <tr>
                                    <td>Código</td>
                                    <td>#<?=str_pad($PedCod, 8, "0", STR_PAD_LEFT);?></td>
                                </tr>
                                <tr>
                                    <td>Fornecedor</td>
                                    <td><?=$ForNome;?></td>
                                </tr>
                                <tr>
                                    <td>Razão Social</td>
                                    <td><?=$UsuNome;?></td>
                                </tr>
                                <tr>
                                    <td>Nome Fantasia</td>
                                    <td><?=$UsuNomeFantasia;?></td>
                                </tr>
                                <tr>
                                    <td>Data</td>
                                    <td><?=converteData($PedData);?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td><?=$PSNome;?></td>
                                </tr>
                                <?php
                                if ($PedObservacao != '') {
                                ?>
                                    <tr>
                                        <td>Observação</td>
                                        <td><?=$PedObservacao;?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" style="margin-top: 30px;">
                    <div style="font-weight: bold; border-bottom: solid 1px #CCC;">Produtos</div>
                    <div style="margin-top: 10px;">
                        <?php
                        if (is_array($itens)) {
                            if (count($itens) > 0) {
                            ?>
                                <table border="0">
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
                                            <td colspan="6"><hr /></td>
                                        </tr>
                                        <tr> 
                                            <td colspan="3" style="font-weight: bold;">TOTAL</td>
                                            <td style="font-weight: bold;"><?=$qtd;?></td>
                                            <td></td>
                                            <td style="font-weight: bold;"><?='R$'.number_format($total,2,',','.');?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>  
        </div>
    </body>
</html>