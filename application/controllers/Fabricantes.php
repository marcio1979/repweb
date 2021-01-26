<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fabricantes extends MY_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('m_fabricantes','',TRUE);
        if ($_SESSION['UsuMaster'] == 0) { redirect(base_url('home')); exit; }
    }
    
    public function index ()
    {
        redirect('fabricantes/listar');
    }
    
    public function listar ()
    {        
        $filtros = array (
            'FabCod' => $this->input->get('FabCod'),
            'FabNome' => $this->input->get('FabNome'),
            'FabAtivo' => $this->input->get('FabAtivo'),
            'FabExcluido' => '0'
        );
        
        $this->params['total'] = $this->m_fabricantes->total($filtros);
        $this->params['ordem'] = $this->input->get('ordem');
        $this->params['sort'] = $this->input->get('sort');
        
        $paginacao = paginacao($this->params['total'], base_url('fabricantes/listar?versao=1&ordem='.$this->params['ordem'].'&sort='.$this->params['sort'].'&'.http_build_query($filtros)), $this->input->get('pag'));
        
        $this->params['paginacao'] = $paginacao['html'];
        $this->params['link'] = '&' . http_build_query($filtros);
        $this->params['dados'] = $this->m_fabricantes->listar($filtros,  $this->params['ordem'],  $this->params['sort'], $paginacao['inicio'], $paginacao['limite']);
        
        $this->params = array_merge($this->params, $filtros);
        
        $this->load->view('fabricantes/v_listar', $this->params);
    }
    
    public function apagar ($FabCod) 
    {
        
        if (!empty($FabCod)) {
            $row = $this->m_fabricantes->listar(array('FabCod' => $FabCod));
            if ($row[0]->FabCod) {
                if ($this->m_fabricantes->excluir($FabCod)) {
                    echo $row[0]->FabCod;
                }
            }
        }
    }
    
    public function alterar ($FabCod)
    {
        
        $dados = $this->m_fabricantes->listar(array('FabCod' => $FabCod));
            
        if ($dados[0]->FabCod) {
                
            $this->params = array (
                'FabCod' => $dados[0]->FabCod,
                'FabNome' => $dados[0]->FabNome,
                'FabAtivo' => $dados[0]->FabAtivo
            );
            
            $this->form_validation->set_rules('FabNome', 'nome', 'required');
            $this->form_validation->set_rules('FabAtivo', 'status', 'required');
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $form = array(
                    'FabCod' => $FabCod,
                    'FabNome' => $this->input->post('FabNome'),
                    'FabAtivo' => $this->input->post('FabAtivo')
                );
                
                $this->params = array_merge($this->params, $form); 
                
                if ($this->form_validation->run() === TRUE) {
                    
                    $update = $this->m_fabricantes->alterar($form);
                    
                    if ($update) {
                        $this->params['type'] = 'alert alert-success';
                        $this->params['msg'] = "Fabricante alterado com sucesso!";
                    } else {
                        $this->params['type'] = 'alert alert-danger';
                        $this->params['msg'] = "Ocorreu um erro na alteração!";
                    }
                }
            }
            
            $this->params['action'] = base_url('fabricantes/alterar/'.$FabCod);
            $this->params['titulo'] = "Alterar";
            $this->load->view('fabricantes/v_alterar', $this->params);
        } else {
            redirect('produtos');
        }
    }

    public function consultar ($FabCod)
    {
        
        $dados = $this->m_fabricantes->listar(array('FabCod' => $FabCod));
        $this->params['titulo'] = "consultar";
        
        if ($dados[0]->FabCod) {
                
            $this->params = array (
                'FabCod' => $dados[0]->FabCod,
                'FabNome' => $dados[0]->FabNome,
                'FabDataCadastro' => $dados[0]->FabDataCadastro,
                'FabAtivo' => $dados[0]->FabAtivo
            );
            
            $this->load->view('fabricantes/v_consultar', $this->params);
        } else {
            redirect('produtos');
        }
    } 

    public function cadastrar ()
    {
        
        $this->form_validation->set_rules('FabNome', 'nome', 'required');
        $this->form_validation->set_rules('FabAtivo', 'status', 'required');
        
        $form = array(
            'FabNome' => $this->input->post('FabNome'),
            'FabAtivo' => $this->input->post('FabAtivo'),
            'FabDataCadastro' => date('Y-m-d H:i:s')
        );
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        
            if ($this->form_validation->run() === TRUE) {
                
                $cadastro = $this->m_fabricantes->cadastrar($form);
                
                if ($cadastro) {
                    redirect('fabricantes/consultar/' . $cadastro);
                } else {
                    $this->params['type'] = 'alert alert-danger';
                    $this->params['msg'] = "Ocorreu um erro no cadastro!";
                }
            }
        }
        
        $this->params['action'] = base_url('fabricantes/cadastrar');
        $this->params['titulo'] = "Cadastrar";
        $this->params = array_merge($this->params, $form); 
        $this->load->view('fabricantes/v_alterar', $this->params);
    }  
}