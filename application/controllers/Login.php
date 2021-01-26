<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
	function __construct()
	{
	 	parent::__construct();
		$this->params = null;
		$this->load->model('m_login','',TRUE);
        $this->load->model('m_emails','',TRUE);
        $this->load->model('m_configuracoes','',TRUE);
        
        //Configurações gerais
        $this->conf = $this->m_configuracoes->listar();
 	}
 
	public function index()
	{
		$this->session->unset_userdata("logged");
		$this->load->view('login/v_login');
	}
	
	public function login(){
        
        $dados = array();
        $email = $this->input->post("email");
        $senha = md5($this->input->post("senha"));
        
        if (!empty($email) && !empty($senha)) {
            
            $result = $this->m_login->login($email, $senha);
            if ($result) {
                if ($result[0]->UsuStatus == 1) {
                    $this->session->set_userdata("logged", 1);
                    $this->session->set_userdata("UsuCod", $result[0]->UsuCod);
                    $this->session->set_userdata("UsuNome", $result[0]->UsuNomeFantasia);
                    $this->session->set_userdata("UsuMaster", $result[0]->UsuMaster);
                    
                    $this->m_login->cadastrarLogAcesso(array('UsuCod' => $result[0]->UsuCod, 'LAEmail' => $email, 'LAData' => date('Y-m-d H:i:s'), 'LAIP' => $_SERVER['REMOTE_ADDR'], 'LATCod' => 1));
                    redirect(base_url());
                } else {
                    $this->m_login->cadastrarLogAcesso(array('UsuCod' => $result[0]->UsuCod, 'LAEmail' => $email, 'LAData' => date('Y-m-d H:i:s'), 'LAIP' => $_SERVER['REMOTE_ADDR'], 'LATCod' => 3));
                    $dados['error'] = "Seu cadastro ainda está em análise. Você receberá um e-mail assim que ele for aprovado!";
                    $dados['type'] = "alert alert-warning";
                }
            } else {
                $this->m_login->cadastrarLogAcesso(array('UsuCod' => 0, 'LAEmail' => $email, 'LAData' => date('Y-m-d H:i:s'), 'LAIP' => $_SERVER['REMOTE_ADDR'], 'LATCod' => 2));
                $dados['error'] = "E-mail ou Senha inválidos.";
                $dados['type'] = "alert alert-danger";
            }
        }

        $this->load->view("login/v_login", $dados);
    }

    public function cadastro(){
        
        $dados['nome'] = $this->input->post("nome");
        $dados['nomefantasia'] = $this->input->post("nomefantasia");
        $dados['nomecontato'] = $this->input->post("nomecontato");
        $dados['documento'] = $this->input->post("documento");
        $dados['email'] = $this->input->post("email");
        $dados['senha'] = md5($this->input->post("senha"));
        $dados['telefone'] = $this->input->post("telefone");
        $dados['celular'] = $this->input->post("celular");
        $dados['endereco'] = $this->input->post("endereco");
        $dados['cidade'] = $this->input->post("cidade");
        $dados['estado'] = $this->input->post("estado");
        
        if (!empty($dados['nome']) && !empty($dados['nomefantasia']) && !empty($dados['nomecontato']) && !empty($dados['documento']) && !empty($dados['email']) && !empty($dados['senha']) && !empty($dados['telefone']) && !empty($dados['celular']) && !empty($dados['endereco']) && !empty($dados['cidade']) && !empty($dados['estado'])) {
            
            $verificaEmail = $this->m_login->verificaEmail($dados['email']);
            if (!$verificaEmail) {
                
                $verificaDocumento = $this->m_login->verificaDocumento( $dados['documento']);
                if (!$verificaDocumento) {
                    
                    $form = array(
                        'UsuNome' => $dados['nome'],
                        'UsuNomeFantasia' => $dados['nomefantasia'],
                        'UsuNomeContato' => $dados['nomecontato'],
                        'UsuDocumento' => $dados['documento'],
                        'UsuEmail' => $dados['email'],
                        'UsuSenha' => $dados['senha'],
                        'UsuCidade' => $dados['cidade'],
                        'UsuEstado' => $dados['estado'],
                        'UsuEndereco' => $dados['endereco'],
                        'UsuTelefone' => $dados['telefone'],
                        'UsuCelular' => $dados['celular'],
                        'UsuMaster' => 0,
                        'UsuDataCadastro' => date('Y-m-d H:i:s'),
                        'UsuIP' => $_SERVER['REMOTE_ADDR'],
                        'UsuStatus' => 0
                    );       
                    $UsuCod = $this->m_login->cadastrar($form);
                    
                    $dados['cadastrado'] = true;
                    $LinkUsuario = '<a href="http://www.representanteweb.com.br/usuarios/consultar/'.$UsuCod.'">http://www.representanteweb.com.br/usuarios/consultar/'.$UsuCod . '</a>';
                    
                    //Carrega e-mail e envia
                    $modeloEmail = $this->m_emails->listar(array('EmaTipo' => 'Novo Cadastro'));
                    $corpoEmail = $modeloEmail[0]->EmaTexto;
                    $tituloEmail = $modeloEmail[0]->EmaTitulo;
                    $this->load->library('email');
                    $this->email->to($this->conf->CfgEmail);
                    $this->email->from('nao-responder@representanteweb.com.br', 'Representante Web');
                    $this->email->subject($tituloEmail);
                    $this->email->message(nl2br(str_replace('{Link}', $LinkUsuario, $corpoEmail)));
                    $this->email->send();
                    
                    $this->load->view("login/v_cadastro", $dados);
                } else {
                    $dados['error'] = "O CNPJ digitado já está cadastrado.";
                    $dados['type'] = "alert alert-danger";
                    $this->load->view("login/v_cadastro", $dados);
                }
            } else {
                $dados['error'] = "O E-mail digitado já está cadastrado.";
                $dados['type'] = "alert alert-danger";
                $this->load->view("login/v_cadastro", $dados);
            }
        } else {
            $this->load->view("login/v_cadastro", $dados);
        }
    }
	
    public function esqueceu_senha () {
        $email = $this->input->get('email');
        $verificaEmail = $this->m_login->verificaEmail($email);
        if (isset($verificaEmail[0]->UsuNome)) {
            
            $chave = md5('R3PW3B'.$email);
            $LinkSenha = '<a href="http://www.representanteweb.com.br/login/nova-senha?chave=' . $chave . '">http://www.representanteweb.com.br/login/nova-senha?chave=' . $chave . '</a>';
            $salvaChave = $this->m_login->salvaChave($email, $chave);
            
            //Carrega e-mail
            $modeloEmail = $this->m_emails->listar(array('EmaTipo' => 'Alteração de Senha'));
            $corpoEmail = $modeloEmail[0]->EmaTexto;
            $tituloEmail = $modeloEmail[0]->EmaTitulo;
            
            if ($salvaChave) { 
                $this->load->library('email');
                $this->email->to($email);
                $this->email->from('nao-responder@representanteweb.com.br', 'Representante Web');
                $this->email->subject($tituloEmail);
                $this->email->message(nl2br(str_replace('{NomeUsuario}', $verificaEmail[0]->UsuNome, str_replace('{Link}', $LinkSenha, $corpoEmail))));

                if($this->email->send()) {
                    echo 'As instruções foram enviadas para seu e-mail!';
                } else {
                    debug($this->email->print_debugger());
                    echo 'Ocorreu um erro no envio do e-mail!';
                }
            }
        } else {
            echo 'O e-mail informado não está cadastrado!';
        }
    }
    
    public function nova_senha () {
        $chave = $this->input->get('chave');
        if ($chave != '') {
            $usuario = $this->m_login->verificaChave($chave);
            if (isset($usuario[0]->UsuCod)) {
                
                $novasenha = $this->input->post('novasenha');
                $repetirnovasenha = $this->input->post('repetirnovasenha');
                
                if ($novasenha != '' && $repetirnovasenha != '') {
                    if ($novasenha == $repetirnovasenha) {
                        $novaSenha = $this->m_login->novaSenha($chave, md5($novasenha));
                        redirect(base_url('login'));
                    } else {
                        $dados['error'] = "As senhas digitadas não conferem!";
                        $dados['type'] = "alert alert-danger";
                    }
                }
                
                $dados['chave'] = $chave;
                $this->load->view("login/v_novasenha", $dados);
            }
        }
    }
    
	public function logout(){
		
		$this->session->unset_userdata("logged");
	
		redirect(base_url('login'));
	}
}