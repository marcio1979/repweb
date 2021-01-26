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
                                    <span>Pesquisar Logs de Acesso</span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="frm" onsubmit="spinner(1);" method="GET" action="<?=base_url('usuarios/logacesso');?>" class="form-horizontal">
                                    <fieldset>
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
                                            <label class="col-sm-3 control-label">Tipo</label>
                                            <div class="col-sm-5">
                                                <?=GeraSelect('LATCod', 'LATCod', 'LATDescricao', $LATCod, 'select * from logacessotipo');?>
                                                <?php echo form_error('PGCod'); ?>
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
                                                    'LACod' => '#',
                                                    'UsuNome' => 'Nome',
                                                    'UsuEmail' => 'E-mail',
                                                    'LAData' => 'Data',
                                                    'LAData ' => 'Hora',
                                                    'LAIP' => 'IP',
                                                    'LATCod' => 'Tipo'
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
                                                    <th class="header <?=$sortClass;?>" onclick="javascript: redirect('<?=base_url("usuarios/logacesso?ordem=" . $th . '&sort=' . $sort . $link); ?>');"><?=$label;?></th>
                                                <?php 
                                                }
                                                ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($dados as $dado => $linha) {
                                            ?>
                                                <tr>
                                                    <td><?=$linha->LACod;?></td>
                                                    <td>
                                                        <?php
                                                        if ($linha->UsuNome != "") {
                                                            echo $linha->UsuNome;
                                                        } else {
                                                            echo 'Desconhecido';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?=$linha->LAEmail;?></td>
                                                    <td><?=date('d/m/Y', strtotime($linha->LAData));?></td>
                                                    <td><?=date('H:i:s', strtotime($linha->LAData));?></td>
                                                    <td><?=$linha->LAIP;?></td>
                                                    <td><?=$linha->LATDescricao;?></td>
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
