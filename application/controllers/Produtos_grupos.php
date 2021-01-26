<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos_grupos extends MY_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('m_produtos_grupos','',TRUE);
        if ($_SESSION['UsuMaster'] == 0) { redirect(base_url('home')); exit; }
    }
    
    public function index ()
    {
        redirect('produtos-grupos/listar');
    }
    
    public function listar ()
    {        
        $filtros = array (
            'PGCod' => $this->input->get('PGCod'),
            'PGNome' => $this->input->get('PGNome'),
            'PGAtivo' => $this->input->get('PGAtivo'),
            'PGExcluido' => '0'
        );
        
        $this->params['total'] = $this->m_produtos_grupos->total($filtros);
        $this->params['ordem'] = $this->input->get('ordem');
        $this->params['sort'] = $this->input->get('sort');
        
        $paginacao = paginacao($this->params['total'], base_url('produtos-grupos/listar?versao=1&ordem='.$this->params['ordem'].'&sort='.$this->params['sort'].'&'.http_build_query($filtros)), $this->input->get('pag'));
        
        $this->params['paginacao'] = $paginacao['html'];
        $this->params['link'] = '&' . http_build_query($filtros);
        $this->params['dados'] = $this->m_produtos_grupos->listar($filtros,  $this->params['ordem'],  $this->params['sort'], $paginacao['inicio'], $paginacao['limite']);
        
        $this->params = array_merge($this->params, $filtros);
        
        $this->load->view('produtos_grupos/v_listar', $this->params);
    }
    
    public function apagar ($PGCod) 
    {        
        if (!empty($PGCod)) {
            $row = $this->m_produtos_grupos->listar(array('PGCod' => $PGCod));
            if ($row[0]->PGCod) {
                if ($this->m_produtos_grupos->excluir($PGCod)) {
                    echo $row[0]->PGCod;
                }
            }
        }
    }
    
    public function alterar ($PGCod)
    {        
        $dados = $this->m_produtos_grupos->listar(array('PGCod' => $PGCod));
            
        if ($dados[0]->PGCod) {
                
            $this->params = array (
                'PGCod' => $dados[0]->PGCod,
                'PGNome' => $dados[0]->PGNome,
                'PGAtivo' => $dados[0]->PGAtivo
            );
            
            $this->form_validation->set_rules('PGNome', 'nome', 'required');
            $this->form_validation->set_rules('PGAtivo', 'status', 'required');
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $form = array(
                    'PGCod' => $PGCod,
                    'PGNome' => $this->input->post('PGNome'),
                    'PGAtivo' => $this->input->post('PGAtivo')
                );
                
                $this->params = array_merge($this->params, $form); 
                
                if ($this->form_validation->run() === TRUE) {
                    
                    $update = $this->m_produtos_grupos->alterar($form);
                    
                    if ($update) {
                        $this->params['type'] = 'alert alert-success';
                        $this->params['msg'] = "Grupo alterado com sucesso!";
                    } else {
                        $this->params['type'] = 'alert alert-danger';
                        $this->params['msg'] = "Ocorreu um erro na alteração!";
                    }
                }
            }
            
            $this->params['action'] = base_url('produtos-grupos/alterar/'.$PGCod);
            $this->params['titulo'] = "Alterar";
            $this->load->view('produtos_grupos/v_alterar', $this->params);
        } else {
            redirect('produtos');
        }
    }

    public function consultar ($PGCod)
    {        
        $dados = $this->m_produtos_grupos->listar(array('PGCod' => $PGCod));
        $this->params['titulo'] = "consultar";
        
        if ($dados[0]->PGCod) {
                
            $this->params = array (
                'PGCod' => $dados[0]->PGCod,
                'PGNome' => $dados[0]->PGNome,
                'PGDataCadastro' => $dados[0]->PGDataCadastro,
                'PGAtivo' => $dados[0]->PGAtivo
            );
            
            $this->load->view('produtos_grupos/v_consultar', $this->params);
        } else {
            redirect('produtos');
        }
    } 

    public function cadastrar ()
    {        
        $this->form_validation->set_rules('PGNome', 'nome', 'required');
        $this->form_validation->set_rules('PGAtivo', 'status', 'required');
        
        $form = array(
            'PGNome' => $this->input->post('PGNome'),
            'PGAtivo' => $this->input->post('PGAtivo'),
            'PGExcluido' => 0,
            'PGDataCadastro' => date('Y-m-d H:i:s'),
            'PGDataUpdate' => date('Y-m-d H:i:s')
        );
            
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        
            if ($this->form_validation->run() === TRUE) {
                
                $cadastro = $this->m_produtos_grupos->cadastrar($form);
                
                if ($cadastro) {
                    redirect('produtos-grupos/consultar/' . $cadastro);
                } else {
                    $this->params['type'] = 'alert alert-danger';
                    $this->params['msg'] = "Ocorreu um erro no cadastro!";
                }
            }
        }
        
        $this->params['action'] = base_url('produtos-grupos/cadastrar');
        $this->params['titulo'] = "Cadastrar";
        $this->params = array_merge($this->params, $form); 
        $this->load->view('produtos_grupos/v_alterar', $this->params);
    }  
}