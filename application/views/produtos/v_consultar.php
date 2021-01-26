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
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="box-name">
                                                <i class="<?=$this->config->item('icon-consultar');?>"></i>
                                                <span>Consultar Produto</span>
                                                <div class="pull-right">
                                                    <a href="<?=base_url('produtos/listar');?>" onclick="redirect('<?=base_url('produtos/listar');?>');" class="btn btn-xs btn-default"><i class="<?=$this->config->item('icon-voltar');?>"></i> voltar</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Nome</label>
                                                    <div class="col-sm-5">
                                                        <?=$ProdNome;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Fornecedor</label>
                                                    <div class="col-sm-5">
                                                        <?=$ForNome;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Fabricante</label>
                                                    <div class="col-sm-5">
                                                        <?=$FabNome;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Código de Referência</label>
                                                    <div class="col-sm-5">
                                                        <?=$ProdCodigoInterno;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Preço de venda</label>
                                                    <div class="col-sm-5">
                                                        R$<?=number_format($ProdValor,2,',','.');?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Descrição</label>
                                                    <div class="col-sm-5">
                                                        <?=$ProdDescricao;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Marcador</label>
                                                    <div class="col-sm-5">
                                                        <span class="label label-<?=$ProdTipoMarcador;?>"><?=$ProdMarcador;?></span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Grupo de Produto</label>
                                                    <div class="col-sm-5">
                                                        <?=$PGNome;?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Data de cadastro</label>
                                                    <div class="col-sm-5">
                                                        <?=converteData($ProdDataCadastro);?>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Ativo</label>
                                                    <div class="col-sm-5">
                                                        <?php 
                                                        if ($ProdAtivo == 1) {
                                                             echo "Sim"; 
                                                        } else {
                                                            echo "Não";
                                                        } 
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($ProdFoto != '') {
                                                ?>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Foto atual</label>
                                                        <div class="col-sm-5">
                                                            <img src="<?=base_url('upload/fotos/'.$ProdFoto);?>" style="max-width: 100%;" />
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
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <style>
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
        </style>
        <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <div class="modal-title" id="produtoNome"><?=$ProdNome;?></div>
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
                       $(this).find('img').css('max-width',$( window ).width()*0.8);
                       $(this).find('img').css('max-height',$( window ).height()*0.8);
                    });
                    $('#imagemodal').modal('show');
                });     
            });
        </script>
    </body>
</html>