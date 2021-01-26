<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emails extends MY_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('m_emails','',TRUE);
        if ($_SESSION['UsuMaster'] == 0) { redirect(base_url('home')); exit; }
    }
    
    public function index ()
    {
        redirect('emails/listar');
    }
    
    public function listar ()
    {        
        $filtros = array (
            'EmaCod' => $this->input->get('EmaCod'),
            'EmaTitulo' => $this->input->get('EmaTitulo'),
            'EmaTexto' => $this->input->get('EmaTexto'),
            'EmaTipo' => $this->input->get('EmaTipo')
        );
        
        $this->params['total'] = $this->m_emails->total($filtros);
        $this->params['ordem'] = $this->input->get('ordem');
        $this->params['sort'] = $this->input->get('sort');
        
        $paginacao = paginacao($this->params['total'], base_url('emails/listar?versao=1&ordem='.$this->params['ordem'].'&sort='.$this->params['sort'].'&'.http_build_query($filtros)), $this->input->get('pag'));
        
        $this->params['paginacao'] = $paginacao['html'];
        $this->params['link'] = '&' . http_build_query($filtros);
        $this->params['dados'] = $this->m_emails->listar($filtros,  $this->params['ordem'],  $this->params['sort'], $paginacao['inicio'], $paginacao['limite']);
        
        $this->params = array_merge($this->params, $filtros);
        
        $this->load->view('emails/v_listar', $this->params);
    }
    
    public function alterar ($EmaCod)
    {        
        $dados = $this->m_emails->listar(array('EmaCod' => $EmaCod));
            
        if ($dados[0]->EmaCod) {
                
            $this->params = array (
                'EmaCod' => $dados[0]->EmaCod,
                'EmaTitulo' => $dados[0]->EmaTitulo,
                'EmaTexto' => $dados[0]->EmaTexto,
                'EmaTipo' => $dados[0]->EmaTipo
            );
            
            $this->form_validation->set_rules('EmaTitulo', 'Título', 'required');
            $this->form_validation->set_rules('EmaTexto', 'Texto', 'required');
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $form = array(
                    'EmaCod' => $EmaCod,
                    'EmaTitulo' => $this->input->post('EmaTitulo'),
                    'EmaTexto' => $this->input->post('EmaTexto')
                );
                
                $this->params = array_merge($this->params, $form); 
                
                if ($this->form_validation->run() === TRUE) {
                    
                    $update = $this->m_emails->alterar($form);
                    
                    if ($update) {
                        $this->params['type'] = 'alert alert-success';
                        $this->params['msg'] = "E-mail alterado com sucesso!";
                    } else {
                        $this->params['type'] = 'alert alert-danger';
                        $this->params['msg'] = "Ocorreu um erro na alteração!";
                    }
                }
            }
            
            $this->params['action'] = base_url('emails/alterar/'.$EmaCod);
            $this->params['titulo'] = "Alterar";
            $this->load->view('emails/v_alterar', $this->params);
        } else {
            redirect('emails');
        }
    }

    public function consultar ($EmaCod)
    {        
        $dados = $this->m_emails->listar(array('EmaCod' => $EmaCod));
        $this->params['titulo'] = "consultar";
        
        if ($dados[0]->EmaCod) {
                
            $this->params = array (
                'EmaCod' => $dados[0]->EmaCod,
                'EmaTitulo' => $dados[0]->EmaTitulo,
                'EmaTexto' => $dados[0]->EmaTexto,
                'EmaTipo' => $dados[0]->EmaTipo
            );
            
            $this->load->view('emails/v_consultar', $this->params);
        } else {
            redirect('produtos');
        }
    }
}