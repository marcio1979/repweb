<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracoes extends MY_Controller {
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('m_configuracoes','',TRUE);
        $this->load->model('m_usuarios','',TRUE);
        $this->load->model('m_produtos','',TRUE);
        $this->load->model('m_fabricantes','',TRUE);
        $this->load->model('m_produtos_grupos','',TRUE);
	}
	
	public function gerais()
    {
        if ($_SESSION['UsuMaster'] == 0) { redirect(base_url('home')); exit; }
        
        $dados = $this->m_configuracoes->listar();
        
        $this->params = array (
            'CfgCod' => $dados->CfgCod,
            'CfgNomeEmpresa' => $dados->CfgNomeEmpresa,
            'CfgTelefone' => $dados->CfgTelefone,
            'CfgEmail' => $dados->CfgEmail,
            'CfgEndereco' => $dados->CfgEndereco,
            'CfgLogo' => $dados->CfgLogo,
            'CfgFavicon' => $dados->CfgFavicon,
        );
        
        $this->form_validation->set_rules('CfgNomeEmpresa', 'Nome da empresa', 'required');
        $this->form_validation->set_rules('CfgTelefone', 'Telefone', 'required');
        $this->form_validation->set_rules('CfgEmail', 'E-mail', 'required');
        $this->form_validation->set_rules('CfgEndereco', 'Endereço', 'required');
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $form = array(
                'CfgNomeEmpresa' => $this->input->post('CfgNomeEmpresa'),
                'CfgTelefone' => $this->input->post('CfgTelefone'),
                'CfgEmail' => $this->input->post('CfgEmail'),
                'CfgEndereco' => $this->input->post('CfgEndereco')
            );
            
            $this->params = array_merge($this->params, $form); 
            
            if ($this->form_validation->run() === TRUE) {
                
                $update = $this->m_configuracoes->alterar($form);
                
                $new_name = md5(time().uniqid());
                $config = array(
                    'upload_path' => './upload/fotos/',
                    'allowed_types' => "gif|jpg|png|jpeg|ico",
                    'max_size' => "2048000",
                    'file_name' => $new_name
                );
                $this->load->library('upload', $config);
                if($this->upload->do_upload('CfgLogo')) { 
                    $logoDetailArray = $this->upload->data();
                    $imageLogo = $logoDetailArray['file_name'];
                    $update = $this->m_configuracoes->alterar(array('CfgLogo' => $imageLogo));
                    $this->params['CfgLogo'] = $imageLogo;
                }
                
                if($this->upload->do_upload('CfgFavicon')) { 
                    $faviconDetailArray = $this->upload->data();
                    $imageFavicon = $faviconDetailArray['file_name'];
                    $update = $this->m_configuracoes->alterar(array('CfgFavicon' => $imageFavicon));
                    $this->params['CfgFavicon'] = $imageFavicon;
                }
                
                if ($update) {
                    $this->params['type'] = 'alert alert-success';
                    $this->params['msg'] = "Configurações alteradas com sucesso!";
                } else {
                    $this->params['type'] = 'alert alert-danger';
                    $this->params['msg'] = "Ocorreu um erro na alteração!";
                }
            }
        }
        
        $this->load->view('configuracoes/v_gerais', $this->params);
    }

    public function alterar_senha()
    {
        $newPassword = $this->input->post("newPassword");
        $confirmPassword = $this->input->post("confirmPassword");
        $oldPassword = $this->input->post("oldPassword");
        
        if ($newPassword != '' && $oldPassword != '' && $confirmPassword != '') {
            if (md5($newPassword) == md5($confirmPassword)) {
                $consulta = $this->m_usuarios->listar(array('UsuCod' => $_SESSION['UsuCod']));
                if ($consulta[0]->UsuSenha == md5($oldPassword)) {
                    $alterar = $this->m_usuarios->alterar(array('UsuSenha' => md5($newPassword), 'UsuCod' => $_SESSION['UsuCod']));
                    $this->params['error'] = "Senha alterada com sucesso!";
                    $this->params['type'] = "alert alert-success";
                } else {
                    $this->params['error'] = "Senha atual inválida.";
                    $this->params['type'] = "alert alert-danger";
                }
            } else {
                $this->params['error'] = "As senhas digitadas não conferem.";
                $this->params['type'] = "alert alert-danger";
            }
        }
        
        $this->load->view('v_alterar_senha', $this->params);
    }
    
    public function atualizarPrecos () {
        if ($_SESSION['UsuMaster'] == 0) { redirect(base_url('home')); exit; }
        
        $ProdCod = $this->input->post("ProdCod");        
        if ($ProdCod) {
            if (is_array($ProdCod)) {
                foreach ($ProdCod as $produto) {
                    $ProdValor = $this->input->post("ProdValor".$produto);
                    $this->m_produtos->alterar(array('ProdCod' => $produto, 'ProdValor' => $ProdValor));
                }
                echo "Produtos atualizados com sucesso!";
            }
        } else {
            echo "Nenhum produto para ser atualizado!";
        }
    }
    
    public function cadastrarProdutos () {
        if ($_SESSION['UsuMaster'] == 0) { redirect(base_url('home')); exit; }
        
        //Retorna todos fabricantes
        $getFabricantes = $this->m_fabricantes->listar(array('FabAtivo' => 1, 'FabExcluido' => 0));
        $fabricantes = array();
        foreach ($getFabricantes as $fabricante => $row) { $fabricantes[$row->FabNome] = $row->FabCod; }
        
        //Retorna todos grupos
        $getGrupos = $this->m_produtos_grupos->listar(array('PGAtivo' => 1, 'PGExcluido' => 0));
        $grupos = array();
        foreach ($getGrupos as $grupo => $row) { $grupos[$row->PGNome] = $row->PGCod; }
        
        $ForCod = $this->input->post("ForCod");
        $ProdCodigoInterno = $this->input->post("ProdCodigoInterno");        
        if ($ProdCodigoInterno) {
            if (is_array($ProdCodigoInterno)) {
                foreach ($ProdCodigoInterno as $produto) {
                    $Descricao = $this->input->post("Descricao".$produto);
                    $Valor = $this->input->post("Valor".$produto);
                    $Fabricante = $this->input->post("Fabricante".$produto);
                    $Grupo = $this->input->post("Grupo".$produto);
                    
                    //Cadastra/Vincula Fabricante
                    if (array_key_exists($Fabricante, $fabricantes)) {
                        $FabCod = $fabricantes[$Fabricante];
                    } else {
                        $FabCod = $this->m_fabricantes->cadastrar(array('FabNome' => $Fabricante, 'FabDataCadastro' => date('Y-m-d H:i:s'), 'FabAtivo' => '1'));
                        $fabricantes[$Fabricante] = $FabCod;
                    }
                    
                    //Cadastra/Vincula Grupo
                    if (array_key_exists($Grupo, $grupos)) {
                        $PGCod = $grupos[$Grupo];
                    } else {
                        $PGCod = $this->m_produtos_grupos->cadastrar(array('PGNome' => $Grupo, 'PGDataCadastro' => date('Y-m-d H:i:s'), 'PGAtivo' => '1'));
                        $grupos[$Grupo] = $PGCod;
                    }
                                        
                    if($FabCod != 0 && $PGCod != 0) {
                        //Cadastra Produto
                        $this->m_produtos->cadastrar(array('PGCod' => $PGCod, 'ForCod' => $ForCod, 'FabCod' => $FabCod, 'ProdNome' => $Descricao, 'ProdCodigoInterno' => $produto, 'ProdValor' => $Valor, 'ProdDataCadastro' => date('Y-m-d H:i:s'), 'ProdAtivo' => '1'));
                    }
                }
                echo "Produtos cadastrados com sucesso!";
            }
        } else {
            echo "Nenhum produto para ser cadastrado!";
        }
    }
    
    public function inativarProdutos () {
        if ($_SESSION['UsuMaster'] == 0) { redirect(base_url('home')); exit; }
        
        $ProdCod = $this->input->post("ProdCod");  
        if ($ProdCod) {
            if (is_array($ProdCod)) {
                foreach ($ProdCod as $produto) {
                    $this->m_produtos->alterar(array('ProdCod' => $produto, 'ProdAtivo' => '0'));
                }
                echo "Produtos inativados com sucesso!";
            }
        } else {
            echo "Nenhum produto para ser inativado!";
        }
    }
    
    public function exportar()
    {
        $this->load->model('m_fornecedores','',TRUE);
        
        $ForCod = $this->input->post("ForCod");
        if ($ForCod != '') {
            $getProdutos = $this->m_produtos->exportar($ForCod);
            if (count($getProdutos) > 0) {
                header( 'Content-Encoding: UTF-8' );
                header( 'Content-type: application/csv' );   
                header( 'Content-Disposition: attachment; filename=exportacao.csv' );   
                header( 'Content-Transfer-Encoding: binary' );
                header( 'Pragma: no-cache');
                
                $out = fopen( 'php://output', 'w' );
                fputs($out, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
                foreach ( $getProdutos as $result )
                {
                    fputcsv( $out, (array)$result, ';' );
                }
                fclose( $out );
            }
        }
    }
    
    public function importar()
    {
        $ForCod = $this->input->post("ForCod");
        $listaCSV = array();
        $listaProdutos = array();
        $naoEncontradosCSV = array();
        $naoEncontradosSistema = array();
        $encontrados = array();
        
        /* Verifica Fornecedor e extensão do arquivo CSV */
        if ($ForCod != '') {
            if (isset($_FILES['arquivo'])) {
                if (pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION) == "csv") {
                    
                    /* Retorna todos produtos do fornecedor */
                    $getProdutos = $this->m_produtos->fornecedor($ForCod);
                    if (count($getProdutos) > 0) {
                        
                        /* Monta array com os produtos */
                        foreach ($getProdutos as $produto => $row) {
                            $listaProdutos[$row->ForNome][$row->FabNome][$row->ProdCodigoInterno] = $row;
                        }
                        
                        /* Importar arquivo CSV */
                        if (($handle = fopen($_FILES['arquivo']['tmp_name'], "r")) !== FALSE) {
                            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                                $data = array_map("utf8_encode", $data);
                                if (isset($data[1]) && isset($data[2]) && isset($data[0])) {
                                    if ($data[1] != '' && $data[2] != '' && $data[0] != '') {
                                        $listaCSV[$data[1]][$data[2]][$data[0]] = array_filter($data);
                                        
                                        /* Produtos encontrados/não encontrados no Sistema */
                                        if (isset($listaProdutos[$data[1]][$data[2]][$data[0]])) {
                                            $encontrados[$data[1]][$data[2]][$data[0]] = $data[0];
                                        } else {
                                            $naoEncontradosSistema[$data[1]][$data[2]][$data[0]] = $data[0];
                                        }
                                    }
                                }
                            }
                            fclose($handle);
                        }
                        
                        if (count($listaCSV) > 0) {                        
                            $naoEncontradosCSV = check_diff($listaProdutos, $listaCSV);
                        } else {
                            $this->params['msg'] = 'A lista importada está vazia! Por favor tente novamente.';
                            $this->params['type'] = 'alert alert-danger';
                        }
                    } else {
                        $this->params['msg'] = 'Fornecedor não encontrado! Por favor selecione novamente.';
                        $this->params['type'] = 'alert alert-danger';
                    }
                } else {
                    $this->params['msg'] = 'O arquivo importado está incorreto! Por favor selecione um arquivo CSV.';
                    $this->params['type'] = 'alert alert-danger';
                }
            }
        }
        
        $this->params['ForCod'] = $ForCod;
        $this->params['listaCSV'] = $listaCSV;
        $this->params['listaProdutos'] = $listaProdutos;
        $this->params['naoEncontradosCSV'] = $naoEncontradosCSV;
        $this->params['naoEncontradosSistema'] = $naoEncontradosSistema;
        $this->params['encontrados'] = $encontrados;
        $this->load->view('configuracoes/v_importar', $this->params);
    }
}