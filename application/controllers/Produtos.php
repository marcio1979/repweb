<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends MY_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('m_produtos','',TRUE);
        if ($_SESSION['UsuMaster'] == 0) { redirect(base_url('home')); exit; }
    }
    
    public function index ()
    {
        redirect('produtos/listar');
    }
    
    public function listar ()
    {
                
        $filtros = array (
            'ProdCodigoInterno' => $this->input->get('ProdCodigoInterno'),
            'ProdNome' => $this->input->get('ProdNome'),
            'PGCod' => $this->input->get('PGCod'),
            'ForCod' => $this->input->get('ForCod'),
            'FabCod' => $this->input->get('FabCod'),
            'ProdAtivo' => $this->input->get('ProdAtivo'),
            'ProdExcluido' => '0'
        );
        
        $this->params['total'] = $this->m_produtos->total($filtros);
        $this->params['ordem'] = $this->input->get('ordem');
        $this->params['sort'] = $this->input->get('sort');
        
        $paginacao = paginacao($this->params['total'], base_url('produtos/listar?versao=1&ordem='.$this->params['ordem'].'&sort='.$this->params['sort'].'&'.http_build_query($filtros)), $this->input->get('pag'));
        
        $this->params['paginacao'] = $paginacao['html'];
        $this->params['link'] = '&' . http_build_query($filtros);
        $this->params['dados'] = $this->m_produtos->listar($filtros,  $this->params['ordem'],  $this->params['sort'], $paginacao['inicio'], $paginacao['limite']);
        
        $this->params = array_merge($this->params, $filtros);
        
        $this->load->view('produtos/v_listar', $this->params);
    }
    
    public function apagar ($ProdCod) 
    {        
        if (!empty($ProdCod)) {
            $row = $this->m_produtos->listar(array('ProdCod' => $ProdCod));
            if ($row[0]->ProdCod) {
                if ($this->m_produtos->excluir($ProdCod)) {
                    echo $row[0]->ProdCod;
                }
            }
        }
    }
    
    public function alterar ($ProdCod)
    {        
        $dados = $this->m_produtos->listar(array('ProdCod' => $ProdCod));
            
        if ($dados[0]->ProdCod) {
                
            $this->params = array (
                'ProdCod' => $dados[0]->ProdCod,
                'ProdCodigoInterno' => $dados[0]->ProdCodigoInterno,
                'ProdNome' => $dados[0]->ProdNome,
                'ProdDescricao' => $dados[0]->ProdDescricao,
                'PGCod' => $dados[0]->PGCod,
                'ForCod' => $dados[0]->ForCod,
                'FabCod' => $dados[0]->FabCod,
                'ProdValor' => $dados[0]->ProdValor,
                'ProdTipoMarcador' => $dados[0]->ProdTipoMarcador,
                'ProdMarcador' => $dados[0]->ProdMarcador,
                'ProdAtivo' => $dados[0]->ProdAtivo,
                'ProdFoto' => $dados[0]->ProdFoto
            );
            
            $this->form_validation->set_rules('ProdNome', 'Nome', 'required');
            $this->form_validation->set_rules('ProdCodigoInterno', 'Código Interno', 'required');
            $this->form_validation->set_rules('PGCod', 'Grupo de produto', 'required');
            $this->form_validation->set_rules('ForCod', 'Fornecedor', 'required');
            $this->form_validation->set_rules('FabCod', 'Fabricante', 'required');
            $this->form_validation->set_rules('ProdValor', 'Preço de Venda', 'required');
            $this->form_validation->set_rules('ProdAtivo', 'status', 'required');
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $form = array(
                    'ProdCod' => $ProdCod,
                    'ProdNome' => $this->input->post('ProdNome'),
                    'ProdDescricao' => $this->input->post('ProdDescricao'),
                    'ProdCodigoInterno' => $this->input->post('ProdCodigoInterno'),
                    'PGCod' => $this->input->post('PGCod'),
                    'ForCod' => $this->input->post('ForCod'),
                    'FabCod' => $this->input->post('FabCod'),
                    'ProdValor' => str_replace(',', '.', $this->input->post('ProdValor')),
                    'ProdAtivo' => $this->input->post('ProdAtivo'),
                    'ProdTipoMarcador' => $this->input->post('ProdTipoMarcador'),
                    'ProdMarcador' => $this->input->post('ProdMarcador')
                );
                
                $this->params = array_merge($this->params, $form); 
                
                if ($this->form_validation->run() === TRUE) {                    
                    $update = $this->m_produtos->alterar($form);
                    
                    $ProdFotoAntiga = $dados[0]->ProdFoto;
                    $new_name = md5(time().uniqid());
                    $config = array(
                        'upload_path' => './upload/fotos/',
                        'allowed_types' => "gif|jpg|png|jpeg|ico",
                        'max_size' => "2048000",
                        'file_name' => $new_name
                    );
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload('ProdFoto')) { 
                        $logoDetailArray = $this->upload->data();
                        $imageLogo = $logoDetailArray['file_name'];
                        $update = $this->m_produtos->alterar(array('ProdFoto' => $imageLogo, 'ProdCod' => $ProdCod));
                        $this->params['ProdFoto'] = $imageLogo;
                        $ProdFotoExcluir = 1;
                    }
                    
                    /* Deleta foto */
                    if ($this->input->post('ProdFotoExcluir') == 1 || isset($ProdFotoExcluir)) {
                        if (!isset($ProdFotoExcluir)) {
                            $update = $this->m_produtos->alterar(array('ProdCod' => $ProdCod, 'ProdFoto' => NULL));
                            $this->params['ProdFoto'] = '';
                        }
                        @unlink('./upload/fotos/'.$ProdFotoAntiga);
                    }
                    
                    if ($update) {
                        $this->params['type'] = 'alert alert-success';
                        $this->params['msg'] = "Produto alterado com sucesso!";
                    } else {
                        $this->params['type'] = 'alert alert-danger';
                        $this->params['msg'] = "Ocorreu um erro na alteração!";
                    }
                }
            }

            $this->params['action'] = base_url('produtos/alterar/'.$ProdCod);
            $this->params['titulo'] = "Alterar";
            $this->load->view('produtos/v_alterar', $this->params);
        } else {
            redirect('produtos');
        }
    }

    public function consultar ($ProdCod)
    {        
        $dados = $this->m_produtos->listar(array('ProdCod' => $ProdCod));
        $this->params['titulo'] = "consultar";
        
        if ($dados[0]->ProdCod) {
                        
            $this->params = array (
                'ProdCod' => $dados[0]->ProdCod,
                'ProdNome' => $dados[0]->ProdNome,
                'ProdDescricao' => $dados[0]->ProdDescricao,
                'ProdCodigoInterno' => $dados[0]->ProdCodigoInterno,
                'PGNome' => $dados[0]->PGNome,
                'ForNome' => $dados[0]->ForNome,
                'FabNome' => $dados[0]->FabNome,
                'ProdValor' => $dados[0]->ProdValor,
                'ProdDataCadastro' => $dados[0]->ProdDataCadastro,
                'ProdAtivo' => $dados[0]->ProdAtivo,
                'ProdFoto' => $dados[0]->ProdFoto,
                'ProdTipoMarcador' => $dados[0]->ProdTipoMarcador,
                'ProdMarcador' => $dados[0]->ProdMarcador
            );
            
            $this->load->view('produtos/v_consultar', $this->params);
        } else {
            redirect('produtos');
        }
    }

    public function cadastrar ()
    {        
        $this->form_validation->set_rules('ProdNome', 'Nome', 'required');
        $this->form_validation->set_rules('ProdCodigoInterno', 'Código Interno', 'required');
        $this->form_validation->set_rules('PGCod', 'Grupo de produto', 'required');
        $this->form_validation->set_rules('ForCod', 'Fornecedor', 'required');
        $this->form_validation->set_rules('FabCod', 'Fabricante', 'required');
        $this->form_validation->set_rules('ProdValor', 'Preço de Venda', 'required');
        $this->form_validation->set_rules('ProdAtivo', 'status', 'required');
        
        $form = array(
            'ProdNome' => $this->input->post('ProdNome'),
            'ProdDescricao' => $this->input->post('ProdDescricao'),
            'ProdCodigoInterno' => $this->input->post('ProdCodigoInterno'),
            'PGCod' => $this->input->post('PGCod'),
            'ForCod' => $this->input->post('ForCod'),
            'FabCod' => $this->input->post('FabCod'),
            'ProdValor' =>  str_replace(',', '.', str_replace('.', '', $this->input->post('ProdValor'))),
            'ProdAtivo' => $this->input->post('ProdAtivo'),
            'ProdTipoMarcador' => $this->input->post('ProdTipoMarcador'),
            'ProdMarcador' => $this->input->post('ProdMarcador'),
            'ProdDataCadastro' => date('Y-m-d H:i:s'),
            'ProdFoto' => ''
        );
                
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        
            if ($this->form_validation->run() === TRUE) {
                
                $cadastro = $this->m_produtos->cadastrar($form);
                
                $new_name = md5(time().uniqid());
                $config = array(
                    'upload_path' => './upload/fotos/',
                    'allowed_types' => "gif|jpg|png|jpeg",
                    'max_size' => "2048000",
                    'file_name' => $new_name
                );
                $this->load->library('upload', $config);
                if($this->upload->do_upload('ProdFoto')) { 
                    $logoDetailArray = $this->upload->data();
                    $image = $logoDetailArray['file_name'];
                    $update = $this->m_produtos->alterar(array('ProdCod' => $cadastro, 'ProdFoto' => $image));
                    $this->params['ProdFoto'] = $image;
                }
                
                if ($cadastro) {                
                    redirect('produtos/consultar/' . $cadastro);
                } else {
                    $this->params['type'] = 'alert alert-danger';
                    $this->params['msg'] = "Ocorreu um erro no cadastro!";
                }
            }
        }
        $this->params['action'] = base_url('produtos/cadastrar');
        $this->params['titulo'] = "Cadastrar";
        $this->params = array_merge($this->params, $form);
        $this->load->view('produtos/v_alterar', $this->params);
    }  
}