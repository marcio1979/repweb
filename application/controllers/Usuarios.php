<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        
        if ($_SESSION['UsuMaster'] == 0) { redirect('home'); }
        
        $this->load->model('m_usuarios','',TRUE);
        $this->load->model('m_login','',TRUE);
        $this->load->model('m_fornecedores','',TRUE);
        $this->load->model('m_configuracoes','',TRUE);
                
        //Configurações gerais
        $this->conf = $this->m_configuracoes->listar();
    }
    
    public function index ()
    {
        redirect('usuarios/listar');
    }
    
    public function listar ()
    {
        $filtros = array (
            'UsuCod' => $this->input->get('UsuCod'),
            'UsuNome' => $this->input->get('UsuNome'),
            'UsuNomeFantasia' => $this->input->get('UsuNomeFantasia'),
            'UsuEmail' => $this->input->get('UsuEmail'),
            'UsuStatus' => $this->input->get('UsuStatus'),
        );
        
        $this->params['total'] = $this->m_usuarios->total($filtros);
        $this->params['ordem'] = $this->input->get('ordem');
        $this->params['sort'] = $this->input->get('sort');
        
        $paginacao = paginacao($this->params['total'], base_url('usuarios/listar?versao=1&ordem='.$this->params['ordem'].'&sort='.$this->params['sort'].'&'.http_build_query($filtros)), $this->input->get('pag'));
        
        $this->params['paginacao'] = $paginacao['html'];
        $this->params['link'] = '&' . http_build_query($filtros);
        $this->params['dados'] = $this->m_usuarios->listar($filtros,  $this->params['ordem'],  $this->params['sort'], $paginacao['inicio'], $paginacao['limite']);
        
        $this->params = array_merge($this->params, $filtros);
        
        $this->load->view('usuarios/v_listar', $this->params);
    }
    
    public function alterar ($UsuCod)
    {
        $dados = $this->m_usuarios->listar(array('UsuCod' => $UsuCod));
            
        if ($dados[0]->UsuCod) {
                
            $this->params = array (
                'UsuCod' => $dados[0]->UsuCod,
                'UsuNome' => $dados[0]->UsuNome,
                'UsuNomeFantasia' => $dados[0]->UsuNomeFantasia,
                'UsuNomeContato' => $dados[0]->UsuNomeContato,
                'UsuDocumento' => $dados[0]->UsuDocumento,
                'UsuEmail' => $dados[0]->UsuEmail,
                'UsuCidade' => $dados[0]->UsuCidade,
                'UsuEstado' => $dados[0]->UsuEstado,
                'UsuEndereco' => $dados[0]->UsuEndereco,
                'UsuTelefone' => $dados[0]->UsuTelefone,
                'UsuCelular' => $dados[0]->UsuCelular,
                'UsuMaster' => $dados[0]->UsuMaster,
                'UsuStatus' => $dados[0]->UsuStatus
            );
            
            $this->form_validation->set_rules('UsuNome', 'Razão Social', 'required');
            $this->form_validation->set_rules('UsuNomeFantasia', 'Nome Fantasia', 'required');
            $this->form_validation->set_rules('UsuNomeContato', 'Nome do Contato', 'required');
            $this->form_validation->set_rules('UsuDocumento', 'CNPJ', 'required');
            $this->form_validation->set_rules('UsuEmail', 'E-mail', 'required');
            $this->form_validation->set_rules('UsuSenha', 'Senha');
            $this->form_validation->set_rules('UsuCidade', 'Cidade', 'required');
            $this->form_validation->set_rules('UsuEstado', 'Estado', 'required');
            $this->form_validation->set_rules('UsuEndereco', 'Endereço', 'required');
            $this->form_validation->set_rules('UsuTelefone', 'Telefone', 'required');
            $this->form_validation->set_rules('UsuCelular', 'Celular', 'required');
            $this->form_validation->set_rules('UsuMaster', 'Usuário master?', 'required');
            $this->form_validation->set_rules('UsuStatus', 'Status', 'required');
            
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $form = array(
                    'UsuCod' => $UsuCod,
                    'UsuNome' => $this->input->post('UsuNome'),
                    'UsuNomeFantasia' => $this->input->post('UsuNomeFantasia'),
                    'UsuNomeContato' => $this->input->post('UsuNomeContato'),
                    'UsuDocumento' => $this->input->post('UsuDocumento'),
                    'UsuEmail' => $this->input->post('UsuEmail'),
                    'UsuCidade' => $this->input->post('UsuCidade'),
                    'UsuEstado' => $this->input->post('UsuEstado'),
                    'UsuEndereco' => $this->input->post('UsuEndereco'),
                    'UsuTelefone' => $this->input->post('UsuTelefone'),
                    'UsuCelular' => $this->input->post('UsuCelular'),
                    'UsuMaster' => $this->input->post('UsuMaster'),
                    'UsuStatus' => $this->input->post('UsuStatus')
                );
                
                $this->params = array_merge($this->params, $form); 
                
                if ($this->form_validation->run() === TRUE) {
                    
                    $update = $this->m_usuarios->alterar($form);
                    
                    $UsuSenha = $this->input->post('UsuSenha');
                    if ($UsuSenha != '') {
                         $update = $this->m_usuarios->alterar(array('UsuCod' => $UsuCod, 'UsuSenha' => md5($UsuSenha)));
                    }
                    
                    $this->m_usuarios->excluirFornecedores($UsuCod);
                    if (isset($_POST['fornecedores'])) {
                        if (count($_POST['fornecedores']) > 0) {
                            foreach ($_POST['fornecedores'] as $fornecedor => $row) {
                                $this->m_usuarios->cadastrarFornecedores(array('UsuCod'=>$UsuCod, 'ForCod' => $row, 'UFCondicaoPagamento' => $_POST['UFCondicaoPagamento'.$row], 'UFDataCadastro' => date('Y-m-d H:i:s')));
                            }
                        }
                    }
                    
                    if ($update) {
                        $this->params['type'] = 'alert alert-success';
                        $this->params['msg'] = "Usuário alterado com sucesso!";
                    } else {
                        $this->params['type'] = 'alert alert-danger';
                        $this->params['msg'] = "Ocorreu um erro na alteração!";
                    }
                }
            }
            
            $this->params['action'] = base_url('usuarios/alterar/'.$UsuCod);
            $this->params['titulo'] = "Alterar";
            
            $this->params['fornecedores'] = $this->m_fornecedores->listar(array('ForAtivo' => 1, 'ForExcluido' => 0), 'ForNome', 'ASC');
            
            $fornecedoresAtuais = $this->m_usuarios->listarFornecedores($UsuCod);
            $this->params['ForCod'] = array();
            if (count($fornecedoresAtuais) > 0) {
                foreach ($fornecedoresAtuais as $fornecedor => $rowFor) {
                    $this->params['ForCod'][$rowFor->ForCod] = $rowFor->UFCondicaoPagamento;
                }
            }
            
            $this->load->view('usuarios/v_alterar', $this->params);
        } else {
            redirect('usuarios');
        }
    }

    public function consultar ($UsuCod)
    {
        $dados = $this->m_usuarios->listar(array('UsuCod' => $UsuCod));
        $this->params['titulo'] = "consultar";
        
        if ($dados[0]->UsuCod) {
                
            $this->params = array (
                'UsuCod' => $dados[0]->UsuCod,
                'UsuNome' => $dados[0]->UsuNome,
                'UsuNomeFantasia' => $dados[0]->UsuNomeFantasia,
                'UsuNomeContato' => $dados[0]->UsuNomeContato,
                'UsuDocumento' => $dados[0]->UsuDocumento,
                'UsuEmail' => $dados[0]->UsuEmail,
                'UsuCidade' => $dados[0]->UsuCidade,
                'UsuEstado' => $dados[0]->UsuEstado,
                'UsuEndereco' => $dados[0]->UsuEndereco,
                'UsuTelefone' => $dados[0]->UsuTelefone,
                'UsuCelular' => $dados[0]->UsuCelular,
                'UsuMaster' => $dados[0]->UsuMaster,
                'UsuStatus' => $dados[0]->UsuStatus,
                'UsuDataCadastro' => $dados[0]->UsuDataCadastro
            );
            
            $this->params['fornecedores'] = $this->m_fornecedores->listar(array('ForAtivo' => 1, 'ForExcluido' => 0), 'ForNome', 'ASC');
            
            $fornecedoresAtuais = $this->m_usuarios->listarFornecedores($UsuCod);
            $this->params['ForCod'] = array();
            if (count($fornecedoresAtuais) > 0) {
                foreach ($fornecedoresAtuais as $fornecedor => $rowFor) {
                    $this->params['ForCod'][$rowFor->ForCod] = $rowFor->UFCondicaoPagamento;
                }
            }
            
            $this->load->view('usuarios/v_consultar', $this->params);
        } else {
            redirect('usuarios');
        }
    } 

    public function cadastrar ()
    {
        $this->form_validation->set_rules('UsuNome', 'Razão Social', 'required');
        $this->form_validation->set_rules('UsuNomeFantasia', 'Nome Fantasia', 'required');
        $this->form_validation->set_rules('UsuNomeContato', 'Nome do Contato', 'required');
        $this->form_validation->set_rules('UsuDocumento', 'CNPJ', 'required');
        $this->form_validation->set_rules('UsuEmail', 'E-mail', 'required');
        $this->form_validation->set_rules('UsuSenha', 'Senha', 'required');
        $this->form_validation->set_rules('UsuCidade', 'Cidade', 'required');
        $this->form_validation->set_rules('UsuEstado', 'Estado', 'required');
        $this->form_validation->set_rules('UsuEndereco', 'Endereço', 'required');
        $this->form_validation->set_rules('UsuTelefone', 'Telefone', 'required');
        $this->form_validation->set_rules('UsuCelular', 'Celular', 'required');
        $this->form_validation->set_rules('UsuMaster', 'Usuário master?', 'required');
        $this->form_validation->set_rules('UsuStatus', 'Status', 'required');
        
        $form = array(
            'UsuNome' => $this->input->post('UsuNome'),
            'UsuNomeFantasia' => $this->input->post('UsuNomeFantasia'),
            'UsuNomeContato' => $this->input->post('UsuNomeContato'),
            'UsuDocumento' => $this->input->post('UsuDocumento'),
            'UsuEmail' => $this->input->post('UsuEmail'),
            'UsuSenha' => md5($this->input->post('UsuSenha')),
            'UsuCidade' => $this->input->post('UsuCidade'),
            'UsuEstado' => $this->input->post('UsuEstado'),
            'UsuEndereco' => $this->input->post('UsuEndereco'),
            'UsuTelefone' => $this->input->post('UsuTelefone'),
            'UsuCelular' => $this->input->post('UsuCelular'),
            'UsuMaster' => $this->input->post('UsuMaster'),
            'UsuStatus' => $this->input->post('UsuStatus'),
            'UsuDataCadastro' => date('Y-m-d H:i:s')
        );
            
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        
            if ($this->form_validation->run() === TRUE) {
                
                $cadastro = $this->m_usuarios->cadastrar($form);
                
                if (isset($_POST['fornecedores'])) {
                    if (count($_POST['fornecedores']) > 0) {
                        foreach ($_POST['fornecedores'] as $fornecedor => $row) {
                            $this->m_usuarios->cadastrarFornecedores(array('UsuCod' => $cadastro, 'ForCod' => $row, 'UFDataCadastro' => date('Y-m-d H:i:s')));
                        }
                    }
                }

                if ($cadastro) {
                    redirect('usuarios/consultar/' . $cadastro);
                } else {
                    $this->params['type'] = 'alert alert-danger';
                    $this->params['msg'] = "Ocorreu um erro no cadastro!";
                }
            }
        }
        
        $this->params['action'] = base_url('usuarios/cadastrar');
        $this->params['titulo'] = "Cadastrar";
        
        $this->params['fornecedores'] = $this->m_fornecedores->listar(array('ForAtivo' => 1, 'ForExcluido' => 0), 'ForNome', 'ASC');
        $this->params['ForCod'] = array();
        
        $this->params = array_merge($this->params, $form); 
        $this->load->view('usuarios/v_alterar', $this->params);
    }

    public function logacesso ()
    {
        $filtros = array (
            'LATCod' => $this->input->get('LATCod'),
            'UsuNome' => $this->input->get('UsuNome'),
            'UsuEmail' => $this->input->get('UsuEmail')
        );
        
        $this->params['total'] = $this->m_login->totalLogAcesso($filtros);
        $this->params['ordem'] = $this->input->get('ordem');
        $this->params['sort'] = $this->input->get('sort');
        
        if ($this->params['ordem'] == '') { $this->params['ordem'] = 'LACod'; $this->params['sort'] = 'DESC'; }
        
        $paginacao = paginacao($this->params['total'], base_url('usuarios/logacesso?versao=1&ordem='.$this->params['ordem'].'&sort='.$this->params['sort'].'&'.http_build_query($filtros)), $this->input->get('pag'));
        
        $this->params['paginacao'] = $paginacao['html'];
        $this->params['link'] = '&' . http_build_query($filtros);
        $this->params['dados'] = $this->m_login->listarLogAcesso($filtros,  $this->params['ordem'],  $this->params['sort'], $paginacao['inicio'], $paginacao['limite']);
        
        $this->params = array_merge($this->params, $filtros);
        
        $this->load->view('usuarios/v_logacesso', $this->params);
    }
}