<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fornecedores extends MY_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('m_fornecedores','',TRUE);
        if ($_SESSION['UsuMaster'] == 0) { redirect(base_url('home')); exit; }
    }
    
    public function index ()
    {
        redirect('fornecedores/listar');
    }
    
    public function listar ()
    {        
        $filtros = array (
            'ForNome' => $this->input->get('ForNome'),
            'ForAtivo' => $this->input->get('ForAtivo'),
            'ForExcluido' => '0'
        );
        
        $this->params['total'] = $this->m_fornecedores->total($filtros);
        $this->params['ordem'] = $this->input->get('ordem');
        $this->params['sort'] = $this->input->get('sort');
        
        $paginacao = paginacao($this->params['total'], base_url('fornecedores/listar?versao=1&ordem='.$this->params['ordem'].'&sort='.$this->params['sort'].'&'.http_build_query($filtros)), $this->input->get('pag'));
        
        $this->params['paginacao'] = $paginacao['html'];
        $this->params['link'] = '&' . http_build_query($filtros);
        $this->params['dados'] = $this->m_fornecedores->listar($filtros,  $this->params['ordem'],  $this->params['sort'], $paginacao['inicio'], $paginacao['limite']);
        
        $this->params = array_merge($this->params, $filtros);
        
        $this->load->view('fornecedores/v_listar', $this->params);
    }
    
    public function apagar ($ForCod) 
    {
        
        if (!empty($ForCod)) {
            $row = $this->m_fornecedores->listar(array('ForCod' => $ForCod));
            if ($row[0]->ForCod) {
                if ($this->m_fornecedores->excluir($ForCod)) {
                    echo $row[0]->ForCod;
                }
            }
        }
    }
    
    public function alterar ($ForCod)
    {
        
        $dados = $this->m_fornecedores->listar(array('ForCod' => $ForCod));
            
        if ($dados[0]->ForCod) {
                
            $this->params = array (
                'ForCod' => $dados[0]->ForCod,
                'ForNome' => $dados[0]->ForNome,
                'ForDescricao' => $dados[0]->ForDescricao,
                'ForLogotipo' => $dados[0]->ForLogotipo,
                'ForFlyer' => $dados[0]->ForFlyer,
                'ForPedidoMinimo' => $dados[0]->ForPedidoMinimo,
                'ForAtivo' => $dados[0]->ForAtivo
            );
            
            $this->form_validation->set_rules('ForNome', 'Nome', 'required');
            $this->form_validation->set_rules('ForPedidoMinimo', 'Pedido Mínimo', 'required');
            $this->form_validation->set_rules('ForAtivo', 'Status', 'required');
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $form = array(
                    'ForCod' => $ForCod,
                    'ForNome' => $this->input->post('ForNome'),
                    'ForDescricao' => $this->input->post('ForDescricao'),
                    'ForPedidoMinimo' => str_replace(',', '.', str_replace('.', '', $this->input->post('ForPedidoMinimo'))),
                    'ForAtivo' => $this->input->post('ForAtivo')
                );
                
                $this->params = array_merge($this->params, $form); 
                
                if ($this->form_validation->run() === TRUE) {
                    
                    $update = $this->m_fornecedores->alterar($form);
                    
                    /* Upload do logotipo */
                    $ForLogotipoAntiga = $dados[0]->ForLogotipo;
                    $new_name = md5(time().uniqid());
                    $config = array(
                        'upload_path' => './upload/fotos/',
                        'allowed_types' => "gif|jpg|png|jpeg|ico",
                        'max_size' => "2048000",
                        'file_name' => $new_name
                    );
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload('ForLogotipo')) { 
                        $logoDetailArray = $this->upload->data();
                        $imageLogo = $logoDetailArray['file_name'];
                        $update = $this->m_fornecedores->alterar(array('ForCod' => $ForCod, 'ForLogotipo' => $imageLogo));
                        $this->params['ForLogotipo'] = $imageLogo;
                        $ForLogotipoExcluir = 1;
                    }
                    
                    /* Deleta logotipo */
                    if ($this->input->post('ForLogotipoExcluir') == 1 || isset($ForLogotipoExcluir)) {
                        if (!isset($ForLogotipoExcluir)) {
                            $update = $this->m_fornecedores->alterar(array('ForCod' => $ForCod, 'ForLogotipo' => NULL));
                            $this->params['ForLogotipo'] = '';
                        }
                        @unlink('./upload/fotos/'.$ForLogotipoAntiga);
                    }
                    
                    /* Upload do flyer */
                    $ForFlyerAntiga = $dados[0]->ForFlyer;
                    $new_name = md5(time().uniqid());
                    $config = array(
                        'upload_path' => './upload/fotos/',
                        'allowed_types' => "gif|jpg|png|jpeg|ico",
                        'max_size' => "2048000",
                        'file_name' => $new_name
                    );
                    $this->load->library('upload', $config);
                    if($this->upload->do_upload('ForFlyer')) { 
                        $flyerDetailArray = $this->upload->data();
                        $imageFlyer = $flyerDetailArray['file_name'];
                        $update = $this->m_fornecedores->alterar(array('ForCod' => $ForCod, 'ForFlyer' => $imageFlyer));
                        $this->params['ForFlyer'] = $imageFlyer;
                        $ForFlyerExcluir = 1;
                    }
                    
                    /* Deleta flyer */
                    if ($this->input->post('ForFlyerExcluir') == 1 || isset($ForFlyerExcluir)) {
                        if (!isset($ForFlyerExcluir)) {
                            $update = $this->m_fornecedores->alterar(array('ForCod' => $ForCod, 'ForFlyer' => NULL));
                            $this->params['ForFlyer'] = '';
                        }
                        @unlink('./upload/fotos/'.$ForFlyerAntiga);
                    }
                    
                    if ($update) {
                        $this->params['type'] = 'alert alert-success';
                        $this->params['msg'] = "Fornecedor alterado com sucesso!";
                    } else {
                        $this->params['type'] = 'alert alert-danger';
                        $this->params['msg'] = "Ocorreu um erro na alteração!";
                    }
                }
            }
            
            $this->params['action'] = base_url('fornecedores/alterar/'.$ForCod);
            $this->params['titulo'] = "Alterar";
            $this->load->view('fornecedores/v_alterar', $this->params);
        } else {
            redirect('produtos');
        }
    }

    public function consultar ($ForCod)
    {
        
        $dados = $this->m_fornecedores->listar(array('ForCod' => $ForCod));
        $this->params['titulo'] = "consultar";
        
        if ($dados[0]->ForCod) {
                
            $this->params = array (
                'ForCod' => $dados[0]->ForCod,
                'ForNome' => $dados[0]->ForNome,
                'ForDescricao' => $dados[0]->ForDescricao,
                'ForLogotipo' => $dados[0]->ForLogotipo,
                'ForFlyer' => $dados[0]->ForFlyer,
                'ForPedidoMinimo' => $dados[0]->ForPedidoMinimo,
                'ForDataCadastro' => $dados[0]->ForDataCadastro,
                'ForAtivo' => $dados[0]->ForAtivo
            );
            
            $this->load->view('fornecedores/v_consultar', $this->params);
        } else {
            redirect('produtos');
        }
    } 

    public function cadastrar ()
    {
        
        $this->form_validation->set_rules('ForNome', 'Nome', 'required');
        $this->form_validation->set_rules('ForPedidoMinimo', 'Pedido Mínimo', 'required');
        $this->form_validation->set_rules('ForAtivo', 'status', 'required');
        
        $form = array(
            'ForNome' => $this->input->post('ForNome'),
            'ForDescricao' => $this->input->post('ForDescricao'),
            'ForPedidoMinimo' => str_replace(',', '.', str_replace('.', '', $this->input->post('ForPedidoMinimo'))),
            'ForAtivo' => $this->input->post('ForAtivo'),
            'ForDataCadastro' => date('Y-m-d H:i:s'),
            'ForLogotipo' => ''
        );
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        
            if ($this->form_validation->run() === TRUE) {
                
                $cadastro = $this->m_fornecedores->cadastrar($form);
                
                /* Upload do logotipo */
                $new_name = md5(time().uniqid());
                $config = array(
                    'upload_path' => './upload/fotos/',
                    'allowed_types' => "gif|jpg|png|jpeg|ico",
                    'max_size' => "2048000",
                    'file_name' => $new_name
                );
                $this->load->library('upload', $config);
                if($this->upload->do_upload('ForLogotipo')) { 
                    $logoDetailArray = $this->upload->data();
                    $imageLogo = $logoDetailArray['file_name'];
                    $update = $this->m_fornecedores->alterar(array('ForCod' => $cadastro, 'ForLogotipo' => $imageLogo));
                    $this->params['ForLogotipo'] = $imageLogo;
                }
                
                /* Upload do flyer */
                $new_name = md5(time().uniqid());
                $config = array(
                    'upload_path' => './upload/fotos/',
                    'allowed_types' => "gif|jpg|png|jpeg|ico",
                    'max_size' => "2048000",
                    'file_name' => $new_name
                );
                $this->load->library('upload', $config);
                if($this->upload->do_upload('ForFlyer')) { 
                    $flyerDetailArray = $this->upload->data();
                    $imageFlyer = $flyerDetailArray['file_name'];
                    $update = $this->m_fornecedores->alterar(array('ForCod' => $cadastro, 'ForFlyer' => $imageFlyer));
                    $this->params['ForFlyer'] = $imageFlyer;
                }
                
                if ($cadastro) {
                    redirect('fornecedores/consultar/' . $cadastro);
                } else {
                    $this->params['type'] = 'alert alert-danger';
                    $this->params['msg'] = "Ocorreu um erro no cadastro!";
                }
            }
        }
        
        $this->params['action'] = base_url('fornecedores/cadastrar');
        $this->params['titulo'] = "Cadastrar";
        $this->params = array_merge($this->params, $form); 
        $this->load->view('fornecedores/v_alterar', $this->params);
    }  
}