<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header" style="float: left;">
        <button type="button" class="navbar-toggle" id="menu-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" style="padding: 5px 5px !important;" href="<?=base_url();?>">
            <img src="<?=base_url('images/logo.png');?>" style="height: 40px;" />
        </a>
    </div>
	<div class="pull-right">
		<div class="pull-right">
		    <ul class="nav navbar-top-links navbar-right">
		        <li class="dropdown">
		            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
		               <?=explode(' ', $_SESSION['UsuNome'])[0];?> <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
		            </a>
		            <ul class="dropdown-menu dropdown-user">
		                <li style="border-bottom: solid 1px #EEE;">
		                	<a href="<?=base_url('configuracoes/alterar-senha');?>"><i class="fa fa-lock"></i> Alterar senha</a>
		                </li>
		                <li>
		                	<a href="<?=base_url('login');?>"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
		                </li>
		            </ul>
		            <!-- /.dropdown-user -->
		        </li>
		        <!-- /.dropdown -->
		    </ul>
		</div>
    </div>
    <div class="navbar-default sidebar" id="sidebar-wrapper" style="clear: both;" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="<?=base_url('home');?>" onclick="redirect('<?=base_url('home');?>');">
                        <i class="fa fa-home"></i> Home
                    </a>
                </li>
                <?php
                if ($_SESSION['UsuMaster'] == 1) {
                ?>
                    <li>
                        <a href="javascript: void 0;">
                            <i class="fa fa-gear"></i> Configurações <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?=base_url('configuracoes/gerais');?>" onclick="redirect('<?=base_url('configuracoes/gerais');?>');"><i class="fa fa-desktop"></i> Configurações Gerais</a>
                            </li>
                            <li>
                                <a href="<?=base_url('configuracoes/importar');?>" onclick="redirect('<?=base_url('configuracoes/importar');?>');"><i class="fa fa-money"></i> Atualizar Preços</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void 0;">
                            <i class="fa fa-tag"></i> Produtos <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?=base_url('produtos-grupos/listar');?>" onclick="redirect('<?=base_url('produtos-grupos/listar');?>');"><i class="fa fa-object-group"></i> Grupos de Produtos</a>
                            </li>
                            <li>
                                <a href="<?=base_url('produtos/listar');?>" onclick="redirect('<?=base_url('produtos/listar');?>');"><i class="fa fa-barcode"></i> Produtos</a>
                            </li>
                            <li>
                                <a href="<?=base_url('fornecedores/listar');?>" onclick="redirect('<?=base_url('fornecedores/listar');?>');"><i class="fa fa-truck"></i> Fornecedores</a>
                            </li>
                            <li>
                                <a href="<?=base_url('fabricantes/listar');?>" onclick="redirect('<?=base_url('fabricantes/listar');?>');"><i class="fa fa-registered"></i> Fabricantes</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void 0;">
                            <i class="fa fa-users"></i> Usuários <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?=base_url('usuarios/listar');?>" onclick="redirect('<?=base_url('usuarios/listar');?>');"><i class="fa fa-user"></i> Usuários</a>
                            </li>
                            <li>
                                <a href="<?=base_url('usuarios/logacesso');?>" onclick="redirect('<?=base_url('usuarios/logacesso');?>');"><i class="fa fa-sitemap"></i> Logs de acesso</a>
                            </li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <li>
                    <a href="javascript: void 0;">
                        <i class="fa fa-shopping-cart"></i> Pedidos <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="<?=base_url('pedidos/listar');?>" onclick="redirect('<?=base_url('pedidos/listar');?>');"><i class="fa fa-tasks"></i> Pedidos</a>
                        </li>
                        <li>
                            <a href="<?=base_url('pedidos/novo');?>" onclick="redirect('<?=base_url('pedidos/novo');?>');"><i class="fa fa-plus"></i> Novo pedido</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="modal fade" id="confirmDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar exclusão</h4>
            </div>
        
            <div class="modal-body">
                <p id="deleteLabel"></p>
                <p class="debug-url"></p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-danger btn-ok" onclick="confirmDelete();">Excluir</a>
                <input type="hidden" name="deletePage" id="deletePage" />
            </div>
        </div>
    </div>
</div>
<div id="shadow" style="display: none;"></div>
<div class="container" id="spinner" style="display: none;">
    <div class="row">
        <div class="spin">
            <span class="one"></span>
            <span class="two"></span>
            <span class="three"></span>
        </div>
    </div>
</div>
<div id="msgAlert" style="display: none;"></div>
