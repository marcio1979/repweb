<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends MY_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('m_pedidos','',TRUE);
        $this->load->model('m_produtos','',TRUE);
        $this->load->model('m_usuarios','',TRUE);
        $this->load->model('m_emails','',TRUE);
        $this->load->model('m_configuracoes','',TRUE);
        
        //Configurações gerais
        $this->conf = $this->m_configuracoes->listar();
    }
    
    public function index ()
    {
        redirect('pedidos/listar');
    }
    
    public function listar ()
    {
        
        $filtros = array (
            'PedCod' => $this->input->get('PedCod'),
            'ForCod' => $this->input->get('ForCod'),
            'PSCod' => $this->input->get('PSCod'),
            'PedData' => $this->input->get('PedData')
        );
        
        if ($_SESSION['UsuMaster'] == 0) { $filtros['UsuCod'] = $_SESSION['UsuCod']; }
        
        $this->params['total'] = $this->m_pedidos->total($filtros);
        $this->params['ordem'] = $this->input->get('ordem');
        $this->params['sort'] = $this->input->get('sort');
        
        $paginacao = paginacao($this->params['total'], base_url('pedidos/listar?versao=1&ordem='.$this->params['ordem'].'&sort='.$this->params['sort'].'&'.http_build_query($filtros)), $this->input->get('pag'));
        
        $this->params['paginacao'] = $paginacao['html'];
        $this->params['link'] = '&' . http_build_query($filtros);
        
        if (is_null($this->params['ordem']) && is_null($this->params['sort'])) {
            $this->params['ordem'] = 'PedCod';
            $this->params['sort'] = 'DESC';
        }
        $this->params['dados'] = $this->m_pedidos->listar($filtros,  $this->params['ordem'],  $this->params['sort'], $paginacao['inicio'], $paginacao['limite']);
        
        $this->params = array_merge($this->params, $filtros);
        
        $this->load->view('pedidos/v_listar', $this->params);
    }
    
    public function processar ($PedCod)
    {
        if ($_SESSION['UsuMaster'] == 0) { $filtros['UsuCod'] = $_SESSION['UsuCod']; }
        $filtros['PedCod'] = $PedCod;
        $filtros['PSCod'] = '';
           
        $dados = $this->m_pedidos->listar($filtros);        
        if ($dados[0]->PedCod) {
                
            $dadosItens = $this->m_pedidos->listarItens(array('PedCod' => $PedCod), 'ProdNome', 'ASC');
            $total = 0;
            if (is_array($dadosItens)) {
                foreach ($dadosItens as $item => $value) {
                    $total += $value->PIQuantidade*$value->PIValor;
                }
            }
            
            $this->params = array (
                'PedCod' => $dados[0]->PedCod,
                'ForNome' => $dados[0]->ForNome,
                'ForPedidoMinimo' => $dados[0]->ForPedidoMinimo,
                'UsuNome' => $dados[0]->UsuNome,
                'UsuNomeFantasia' => $dados[0]->UsuNomeFantasia,
                'UFCondicaoPagamento' => $dados[0]->UFCondicaoPagamento,
                'PSCod' => $dados[0]->PSCod,
                'PSNome' => $dados[0]->PSNome,
                'PedData' => $dados[0]->PedData,
                'PedObservacao' => $dados[0]->PedObservacao,
                'itens' => $dadosItens,
                'total' => $total
            );
            
            $this->load->view('pedidos/v_processar', $this->params);
        } else {
            redirect('pedidos/novo');
        }
    } 
    
    public function novo ()
    {
        //Verifica se pedido já existe e cria
        $pedido = $this->m_pedidos->listar(array('PedSessao' => session_id(), 'PSCod' => '0'));
        if (!isset($pedido[0]->PedCod)) {
            $form = array(
                'UsuCod' => $_SESSION['UsuCod'],
                'PedData' => date('Y-m-d H:i:s'),
                'PSCod' => 0,
                'PedSessao' => session_id()
            );
            $PedCod = $this->m_pedidos->cadastrar($form);
            $pedido[0] = $form;
        } else {
            $alterar = $this->m_pedidos->alterar(array('PedCod' => $pedido[0]->PedCod, 'UsuCod' => $_SESSION['UsuCod']));
            $PedCod = $pedido[0]->PedCod;
        }
        
        //Carrega todos fornecedores liberados
        $fornecedoresLiberados = array();
        $fornecedores = $this->m_usuarios->listarFornecedores($_SESSION['UsuCod']);
        if (is_array($fornecedores)) {
            if (count($fornecedores) > 0) {
                $fornecedoresLiberados['trocar'] = 'trocar';
                foreach ($fornecedores as $fornecedor => $row) {
                    $fornecedoresLiberados[$row->ForCod] = $row->ForNome;
                }
            }
        }

        //Verifica se foi passado o código do fornecedor e reinicia pedido
        $ForCod = $this->input->get('ForCod');
        if (!empty($ForCod)) {
            if (array_key_exists($ForCod, $fornecedoresLiberados)) {
                
                if ($ForCod == 'trocar') { $ForCod = NULL; }
                $form = array(
                    'PedCod' => $PedCod,
                    'ForCod' => $ForCod
                );
                $alterar = $this->m_pedidos->alterar($form);
                $deletarTodos = $this->m_pedidos->deletarTodos($PedCod);
                unset($_SESSION['ForFlyer'.$ForCod]);
                
                redirect(base_url('pedidos/novo'));
            } else {
                redirect(base_url('pedidos/novo'));
            }
        }
        
        $this->params['fornecedores'] = $fornecedores;
        $this->params['pedido'] = $pedido[0];
        $this->params['produtos'] = $this->m_pedidos->listarItens(array('PedSessao' => session_id()), 'ProdNome', 'ASC');
        
        $this->load->view('pedidos/v_novo', $this->params);
    }
    
    public function pedidoItem ($PedCod = null, $ProdCod = null, $Quantidade = 0)
    {
        
        if ($PedCod != NULL) {
            if ($_SESSION['UsuMaster'] == 0) { $filtros['UsuCod'] = $_SESSION['UsuCod']; }
            $filtros['PedCod'] = $PedCod;
            $pedido = $this->m_pedidos->listar($filtros);
            if (isset($pedido[0]->ForCod)) {
                if ($pedido[0]->PSCod != 3 && $pedido[0]->PSCod != 4) {
                    $PedCod = $pedido[0]->PedCod;
                    $produto = $this->m_produtos->listar(array('ProdCod' => $ProdCod, 'ProdAtivo' => 1, 'ProdExcluido' => 0, 'ForCod' => $pedido[0]->ForCod));
                    if (isset($produto[0]->ProdCod)) {
                        $deletarItem = $this->m_pedidos->deletarItem($PedCod, $ProdCod);
                        
                        if ($Quantidade > 0) {
                            $cadastrarItem = $this->m_pedidos->cadastrarItem(array('PedCod' => $PedCod, 'ProdCod' => $ProdCod, 'PIQuantidade' => $Quantidade, 'PIValor' => $produto[0]->ProdValor));
                        }
                        
                        echo json_encode(array('error' => '', 'total' => 'R$'.number_format(($Quantidade*$produto[0]->ProdValor), 2, ',', '.')));
                    } else {
                        echo json_encode(array('error' => 'produto não existe para esse fornecedor!'));
                    }
                } else {
                    echo json_encode(array('error' => 'esse pedido não pode ser alterado!'));
                }
            } else {
                echo json_encode(array('error' => 'pedido não encontrado!'));
            }
        }
    }

    public function produtos ($PedCod = NULL)
    {
        if ($PedCod != NULL) {
            if ($_SESSION['UsuMaster'] == 0) { $filtros['UsuCod'] = $_SESSION['UsuCod']; }
            $filtros['PedCod'] = $PedCod;
            $pedido = $this->m_pedidos->listar($filtros);
            if (isset($pedido[0]->ForCod)) {
                if ($pedido[0]->PSCod != 3 && $pedido[0]->PSCod != 4) {
                    $pedidosItens = $this->m_pedidos->listarItens(array('PedCod' => $PedCod), 'ProdNome', 'ASC');
                }
            }
        }
        
        if (!isset($pedidosItens)) {
            redirect(base_url('pedidos/novo'));
        } else {
            $filtros = array (
                'ProdCodigoInterno' => $this->input->get('ProdCodigoInterno'),
                'ProdNome' => $this->input->get('ProdNome'),
                'PGCod' => $this->input->get('PGCod'),
                'FabCod' => $this->input->get('FabCod'),
                'ProdAtivo' => 1,
                'ProdExcluido' => '0',
                'ForCod' => $pedido[0]->ForCod
            );
            
            $this->params['total'] = $this->m_produtos->total($filtros);
            $paginacao = paginacao($this->params['total'], base_url('pedidos/produtos/'.$PedCod.'?versao=1&'.http_build_query($filtros)), $this->input->get('pag'), 100);
            
            $this->params['paginacao'] = $paginacao['html'];
            $this->params['link'] = '&' . http_build_query($filtros);
            $this->params['ordem'] = 'FabNome, ProdNome';
            $this->params['sort'] = 'ASC';
            $this->params['dados'] = $this->m_produtos->listar($filtros,  $this->params['ordem'],  $this->params['sort'], $paginacao['inicio'], $paginacao['limite']);
            
            $this->params = array_merge($this->params, $filtros);
            
            $this->params['pedidosItens'] = array();
            if (is_array($pedidosItens)) {
                if (count($pedidosItens) > 0) {
                    foreach ($pedidosItens as $item => $row) {
                        $this->params['pedidosItens'][$row->ProdCod] = $row->PIQuantidade;
                    }
                }
            }
            $this->params['ForCod'] = $pedido[0]->ForCod;
            $this->params['PedCod'] = $pedido[0]->PedCod;
            $this->load->view('pedidos/v_produtos', $this->params);
        }
    }
    
    public function finalizar ()
    {
        
        $pedido = $this->m_pedidos->listar(array('PedSessao' => session_id(), 'PSCod' => '0'));   
        if (isset($pedido[0]->ForCod)) {
 
            if ($pedido[0]->ForPedidoMinimo > $pedido[0]->totalPedido) {
                redirect('pedidos/novo');
            } else {
                $itens = $this->m_pedidos->listarItens(array('PedCod' => $pedido[0]->PedCod));
                
                if (count($itens) > 0) {
                    $form = array(
                        'PedCod' => $pedido[0]->PedCod,
                        'PSCod' => 1,
                        'PedData' => date('Y-m-d H:i:s'),
                        'PedSessao' => NULL
                    );
                    $finalizar = $this->m_pedidos->alterar($form);
                    $LinkPedido = '<a href="http://www.representanteweb.com.br/pedidos/processar/'.$pedido[0]->PedCod.'">http://www.representanteweb.com.br/pedidos/processar/'.$pedido[0]->PedCod . '</a>';

                    //Carrega e-mail e envia
                    $modeloEmail = $this->m_emails->listar(array('EmaTipo' => 'Novo Pedido'));
                    $corpoEmail = $modeloEmail[0]->EmaTexto;
                    $tituloEmail = $modeloEmail[0]->EmaTitulo;
                    $this->load->library('email');
                    $this->email->to($this->conf->CfgEmail);
                    $this->email->from('nao-responder@representanteweb.com.br', 'Representante Web');
                    $this->email->subject($tituloEmail);
                    $this->email->message(nl2br(str_replace('{Link}', $LinkPedido, $corpoEmail)));
                    $this->email->send();
                    
                    $this->session->set_flashdata('finalizado', 'finalizado');
                    redirect('pedidos/novo');
                } else {
                    redirect('pedidos/novo');
                }
            }
        } else {
            redirect('pedidos/novo');
        }
    }
    
    public function pdf ($PedCod = null) {
        
        if ($_SESSION['UsuMaster'] == 0) { $filtros['UsuCod'] = $_SESSION['UsuCod']; }
        $filtros['PedCod'] = $PedCod;
           
        $dados = $this->m_pedidos->listar($filtros);        
        if ($dados[0]->PedCod) {
                
            $dadosItens = $this->m_pedidos->listarItens(array('PedCod' => $PedCod), 'ProdNome', 'ASC');
            
            $this->params = array (
                'PedCod' => $dados[0]->PedCod,
                'ForNome' => $dados[0]->ForNome,
                'UsuNome' => $dados[0]->UsuNome,
                'UsuNomeFantasia' => $dados[0]->UsuNomeFantasia,
                'PSCod' => $dados[0]->PSCod,
                'PSNome' => $dados[0]->PSNome,
                'PedData' => $dados[0]->PedData,
                'PedObservacao' => $dados[0]->PedObservacao,
                'itens' => $dadosItens
            );
            
            include APPPATH . 'third_party/mpdf/mpdf.php';
            $html = $this->load->view('pedidos/v_pdf', $this->params, true);
            $mpdf = new mPDF('utf-8', 'A4');
            $mpdf->dpi = 120;
            $mpdf->WriteHTML($html);
            $mpdf->debug = true;
            $mpdf->autoPageBreak = false;
            $mpdf->Output('pedido'.$PedCod.'.pdf', 'D');
        } else {
            redirect('pedidos');
        }
    }
    
    public function observacao () 
    {
        $observacao = $this->input->post('observacao');
        $pedido = $this->m_pedidos->listar(array('PedSessao' => session_id(), 'PSCod' => '0'));   
        if (isset($pedido[0]->ForCod)) {
            $salvar = $this->m_pedidos->alterar(array('PedCod' => $pedido[0]->PedCod, 'PedObservacao' => $observacao));
        }
    }
    
    public function status ($PedCod = null, $PSCod = null) 
    {    
        
        if ($PedCod != '' && in_array($PSCod, array('2', '3', '4'))) {
            $dados = $this->m_pedidos->listar(array('PedCod' => $PedCod));
            if (isset($dados[0]->PedCod)) {
                if ($dados[0]->PSCod == 1 || $dados[0]->PSCod == 2) {
                    $update = $this->m_pedidos->alterar(array('PedCod' => $PedCod, 'PSCod' => $PSCod));
                    redirect('pedidos/processar/'.$PedCod);
                } else {
                    redirect('pedidos/processar/'.$PedCod);
                }
            }
        }
    }
    
}