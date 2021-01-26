<?php
$totalEncontrados = 0;
$totalPlanilha = 0;
?>
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
                        <div id="wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12">
                                    <?php
                                    if (isset($msg)) {
                                    ?>
                                        <div class="<?=$type;?>"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?=$msg;?></div>
                                    <?php
                                    }
                                    ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="box-name">
                                                <i class="<?=$this->config->item('icon-alterar');?>"></i>
                                                <span>Importar Planilha</span>
                                                <?php
                                                if (!empty($encontrados) || !empty($naoEncontradosCSV) || !empty($naoEncontradosSistema)) {
                                                ?>
                                                    <div class="pull-right">
                                                        <a href="<?=base_url('configuracoes/importar');?>" onclick="redirect('<?=base_url('configuracoes/importar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> voltar</a>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php
                                            if (empty($encontrados) && empty($naoEncontradosCSV) && empty($naoEncontradosSistema)) {
                                            ?>
                                                <form id="frm" onsubmit="spinner(1);" method="POST" enctype="multipart/form-data" action="<?=base_url('configuracoes/importar');?>" class="form-horizontal">
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Arquivo CSV</label>
                                                            <div class="col-sm-5">
                                                                <input type="file" class="form-control" size="50" id="arquivo" name="arquivo" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Fornecedor</label>
                                                            <div class="col-sm-5">
                                                                <?=GeraSelect('ForCod', 'ForCod', 'ForNome', 0, 'Select * From fornecedores Where ForExcluido = 0 And ForAtivo = 1 Order by ForNome Asc');?>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="form-group">
                                                        <div class="col-sm-9 col-sm-offset-3">
                                                            <button type="submit" class="btn btn-primary">Importar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            <?php
                                            } else {
                                            ?>
                                                <div id="tableAtualizar">
                                                    <form class="table-responsive" id="frmAtualizar" action="<?=base_url('configuracoes/atualizarPrecos');?>" method="POST">
                                                        <h4 style="float: left;">Produtos encontrados no Sistema</h4>
                                                        <input type="submit" class="btn btn-primary pull-right" id="btnAtualizar" style="display: none;" value="CONFIRMAR">
                                                        <table class="table table-bordered table-striped table-hover table-heading table-datatable">
                                                            <thead>
                                                                <th>Código</th>
                                                                <th>Fornecedor</th>
                                                                <th>Fabricante</th>
                                                                <th>Descrição</th>
                                                                <th>Grupo</th>
                                                                <th>Valor Antigo</th>
                                                                <th>Valor Novo</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (count($encontrados) > 0) {
                                                                    foreach ($encontrados as $fornecedor => $fabricantes) {
                                                                        foreach ($fabricantes as $fabricante => $produtos) {
                                                                            foreach ($produtos as $produto) {
                                                                                $row = $listaProdutos[$fornecedor][$fabricante][$produto];
                                                                                if (isset($listaCSV[$fornecedor][$fabricante][$row->ProdCodigoInterno][5])) {
                                                                                    $valor = (float)trim(str_replace('R$', '', str_replace(',', '.', $listaCSV[$fornecedor][$fabricante][$row->ProdCodigoInterno][5])));
                                                                                } else {
                                                                                    $valor = '0.00';
                                                                                }
                                                                                if ($valor != $row->ProdValor) {
                                                                                    $totalEncontrados++;
                                                                                    ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <input type="hidden" name="ProdCod[]" value="<?=$row->ProdCod;?>" />
                                                                                            <?=$row->ProdCodigoInterno;?>
                                                                                        </td>
                                                                                        <td><?=$row->ForNome;?></td>
                                                                                        <td><?=$row->FabNome;?></td>
                                                                                        <td><?=$row->ProdNome;?></td>
                                                                                        <td><?=$row->PGNome;?></td>
                                                                                        <td>R$<?=number_format($row->ProdValor,2,',','.');?></td>
                                                                                        <td style="font-weight: bold;">
                                                                                            <?php
                                                                                            if ($valor < $row->ProdValor) {
                                                                                                echo '<span style="color: red;">';
                                                                                            } else {
                                                                                                echo '<span style="color: blue;">';
                                                                                            }
                                                                                            ?>
                                                                                            R$<?=number_format($valor,2,',','.');?>
                                                                                            </span>
                                                                                            <input type="hidden" name="ProdValor<?=$row->ProdCod;?>" value="<?=$valor;?>" />
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                if ($totalEncontrados == 0) {
                                                                ?>
                                                                    <tr>
                                                                        <td colspan="7">Nenhum produto encontrado.</td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                                <div id="tableCadastrar">
                                                    <form class="table-responsive" id="frmCadastrar" action="<?=base_url('configuracoes/cadastrarProdutos');?>" method="POST">
                                                        <input type="hidden" name="ForCod" value="<?=$ForCod;?>" />
                                                        <h4 style="float: left;">Produtos não encontrados no Sistema</h4>
                                                        <input type="submit" class="btn btn-success pull-right" value="CADASTRAR" id="btnCadastrar" style="display: none;">
                                                        <table class="table table-bordered table-striped table-hover table-heading table-datatable">
                                                            <thead>
                                                                <th>Código</th>
                                                                <th>Fornecedor</th>
                                                                <th>Fabricante</th>
                                                                <th>Descrição</th>
                                                                <th>Grupo</th>
                                                                <th>Valor</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (count($naoEncontradosSistema) > 0) {
                                                                    foreach ($naoEncontradosSistema as $fornecedor => $fabricantes) {
                                                                        foreach ($fabricantes as $fabricante => $produtos) {
                                                                            foreach ($produtos as $produto) {
                                                                                if (isset($listaCSV[$fornecedor][$fabricante][$produto][5])) {
                                                                                    $valor = (float)trim(str_replace('R$', '', str_replace(',', '.', $listaCSV[$fornecedor][$fabricante][$produto][5])));
                                                                                } else {
                                                                                    $valor = 0.00;
                                                                                }
                                                                                $descricao = $listaCSV[$fornecedor][$fabricante][$produto][3];
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <input type="hidden" name="ProdCodigoInterno[]" value="<?=$produto;?>" />
                                                                                        <?=$produto;?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?=$fornecedor;?>
                                                                                    </td>
                                                                                    <td>
                                                                                        <?=$fabricante;?>
                                                                                        <input type="hidden" name="Fabricante<?=$produto;?>" value="<?=$fabricante;?>" />
                                                                                    </td>
                                                                                    <td>
                                                                                        <?=$descricao;?>
                                                                                        <input type="hidden" name="Descricao<?=$produto;?>" value="<?=$descricao;?>" />
                                                                                    </td>
                                                                                    <td>
                                                                                        <?=$listaCSV[$fornecedor][$fabricante][$produto][4];?>
                                                                                        <input type="hidden" name="Grupo<?=$produto;?>" value="<?=$listaCSV[$fornecedor][$fabricante][$produto][4];?>" />
                                                                                    </td>
                                                                                    <td>
                                                                                        R$<?=number_format($valor,2,',','.');?>
                                                                                        <input type="hidden" name="Valor<?=$produto;?>" value="<?=$valor;?>" />
                                                                                    </td>
                                                                                </tr>
                                                                            <?php
                                                                            }
                                                                        }
                                                                    }
                                                                } else {
                                                                ?>
                                                                    <tr>
                                                                        <td colspan="6">Nenhum produto encontrado.</td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                                <div id="tableInativar">
                                                    <form class="table-responsive" id="frmInativar" action="<?=base_url('configuracoes/inativarProdutos');?>" method="POST">
                                                        <h4 style="float: left;">Produtos não encontrados na Planilha</h4>
                                                        <input type="submit" class="btn btn-danger pull-right" id="btnInativar" style="display: none;" value="INATIVAR">
                                                        <table class="table table-bordered table-striped table-hover table-heading table-datatable">
                                                            <thead>
                                                                <th>Código</th>
                                                                <th>Fornecedor</th>
                                                                <th>Fabricante</th>
                                                                <th>Descrição</th>
                                                                <th>Grupo</th>
                                                                <th>Valor</th>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (count($naoEncontradosCSV) > 0) {
                                                                    foreach ($naoEncontradosCSV as $fornecedor => $fabricantes) {
                                                                        foreach ($fabricantes as $fabricante => $produtos) {
                                                                            foreach ($produtos as $produto => $row) {
                                                                                $totalPlanilha++;
                                                                                ?>
                                                                                <tr>
                                                                                    <td>
                                                                                        <input type="hidden" name="ProdCod[]" value="<?=$row->ProdCod;?>" />
                                                                                        <?=$row->ProdCodigoInterno;?>
                                                                                    </td>
                                                                                    <td><?=$row->ForNome;?></td>
                                                                                    <td><?=$row->FabNome;?></td>
                                                                                    <td><?=$row->ProdNome;?></td>
                                                                                    <td><?=$row->PGNome;?></td>
                                                                                    <td>R$<?=number_format($row->ProdValor,2,',','.');?></td>
                                                                                </tr>
                                                                            <?php
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                if ($totalPlanilha == 0) {
                                                                ?>
                                                                    <tr>
                                                                        <td colspan="6">Nenhum produto encontrado.</td>
                                                                    </tr>
                                                                <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    if (empty($encontrados) && empty($naoEncontradosCSV) && empty($naoEncontradosSistema)) {
                                    ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <div class="box-name">
                                                    <i class="<?=$this->config->item('icon-alterar');?>"></i>
                                                    <span>Exportar Planilha</span>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <form id="frm" method="POST" target="_blank" enctype="multipart/form-data" action="<?=base_url('configuracoes/exportar');?>" class="form-horizontal">
                                                    <fieldset>
                                                        <div class="form-group">
                                                            <label class="col-sm-3 control-label">Fornecedor</label>
                                                            <div class="col-sm-5">
                                                                <?=GeraSelect('ForCod', 'ForCod', 'ForNome', 0, 'Select * From fornecedores Where ForExcluido = 0 And ForAtivo = 1 Order by ForNome Asc');?>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                    <div class="form-group">
                                                        <div class="col-sm-9 col-sm-offset-3">
                                                            <button type="submit" class="btn btn-success">Exportar</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <?php $this->load->view('main/scripts'); ?>
        <script>
            $(document).ready(function() {
                <?php
                if ($totalEncontrados > 0) {
                ?>
                    $('#btnAtualizar').css('display', '');
                <?php
                }
                if ($totalPlanilha) {
                ?>
                    $('#btnInativar').css('display', '');
                <?php
                }
                if (count($naoEncontradosSistema) > 0) {
                ?>
                    $('#btnCadastrar').css('display', '');
                <?php
                }
                ?>
                
                $("#wrapper").toggleClass("toggled");
                
                $("#frmAtualizar").submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var url = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(),
                        success: function(data)
                        {
                            $('#tableAtualizar').html('<h4 style="float: left;">Produtos encontrados no Sistema</h4><div style="clear: both;" class="alert alert-success">'+data+'</div>');
                            return false;
                        }
                    });
                });
                
                $("#frmInativar").submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var url = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(),
                        success: function(data)
                        {
                            $('#tableInativar').html('<h4 style="float: left;">Produtos não encontrados na Planilha</h4><div style="clear: both;" class="alert alert-success">'+data+'</div>');
                            return false;
                        }
                    });
                });
                
                $("#frmCadastrar").submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var url = form.attr('action');
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(),
                        success: function(data)
                        {
                            $('#tableCadastrar').html('<h4 style="float: left;">Produtos não encontrados no Sistema</h4><div style="clear: both;" class="alert alert-success">'+data+'</div>');
                            return false;
                        }
                    });
                });
            });
        </script>
    </body>
</html>