<?php
defined('BASEPATH') OR exit('No direct script access allowed');
        
Class M_pedidos extends CI_Model
{
    public function total ($filtros) {
        $result = $this->listar($filtros);
        return count($result);
    }
    
    public function listar ($filtros, $ordem = null, $sort = null, $inicio = null, $limite = null)
    {
        $this->db->select('pedidos.PedCod, pedidos.UsuCod, pedidos.ForCod, PedData, pedidos.PSCod, pedidos.PedObservacao, PSNome, UsuNome, UsuNomeFantasia, ForNome, ForLogotipo, ForFlyer, ForPedidoMinimo, UFCondicaoPagamento, (select sum(PIQuantidade*PIValor) from pedidositens where pedidositens.PedCod = pedidos.PedCod) as totalPedido');
        $this->db->from('pedidos');
        $this->db->join('usuarios', 'usuarios.UsuCod = pedidos.UsuCod', 'inner');
        $this->db->join('fornecedores', 'fornecedores.ForCod = pedidos.ForCod', 'left');
        $this->db->join('pedidosstatus', 'pedidosstatus.PSCod = pedidos.PSCod', 'left');
        $this->db->join('usuarios_fornecedores', 'usuarios_fornecedores.UsuCod = pedidos.UsuCod And usuarios_fornecedores.ForCod = fornecedores.ForCod', 'left');
        
        if (isset($inicio) && isset($limite)) {
            $this->db->limit($limite, $inicio);        
        }
        
        if (isset($ordem) && isset($sort)) {
            $this->db->order_by($ordem, $sort);
        }
        
        foreach ($filtros as $dado => $filtro) { 
            if ($filtro != '') { 
                if ($dado == 'UsuCod' || $dado == 'ForCod' || $dado == 'PedCod' || $dado == 'PedSessao' || $dado == 'PSCod') {
                    $this->db->where('pedidos.'.$dado, $filtro);
                } elseif ($dado == 'PedData') {
                    $this->db->where('DATE('.$dado.')', converteData($filtro));
                } else {
                    $this->db->like($dado, $filtro);
                }
            }
            
            if ($dado == 'PSCod' && $filtro == '') {
                $this->db->where('pedidos.PSCod != 0');
            }
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    public function listarItens ($filtros, $ordem = null, $sort = null, $inicio = null, $limite = null)
    {
        $this->db->select('pedidos.PedCod, PICod, produtos.ProdCod, ProdFoto, ProdCodigoInterno, ProdDescricao, ProdNome, FabNome, PIValor, PIQuantidade');
        $this->db->from('pedidos');
        $this->db->join('pedidositens', 'pedidos.PedCod = pedidositens.PedCod', 'inner');
        $this->db->join('produtos', 'produtos.ProdCod = pedidositens.ProdCod', 'inner');
        $this->db->join('fabricantes', 'produtos.FabCod = fabricantes.FabCod', 'inner');
        
        if (isset($inicio) && isset($limite)) {
            $this->db->limit($limite, $inicio);        
        }
        
        if (isset($ordem) && isset($sort)) {
            $this->db->order_by($ordem, $sort);
        }
        
        foreach ($filtros as $dado => $filtro) { 
            if ($filtro != '') { 
                if ($dado == 'PedCod' || $dado == 'ProdCod' || $dado == 'PICod') {
                    $this->db->where('pedidositens.'.$dado, $filtro);
                } elseif ($dado == 'PedSessao') {
                    $this->db->where('pedidos.'.$dado, $filtro);
                } elseif ($dado == 'PedData') {
                    $this->db->where($dado, converteData($filtro));
                } else {
                    $this->db->like($dado, $filtro);
                }
            }
        }
         
        $query = $this->db->get();
        return $query->result();
    }

    public function cadastrar($dados) {
        $this->db->insert('pedidos', $dados);
        return $this->db->insert_id();
    }
    
    public function alterar ($dados)
    {
        $this->db->where('PedCod', $dados['PedCod']);
        $this->db->update('pedidos', $dados);
        return true;
    }
    
    public function cadastrarItem ($dados) {
        $this->db->insert('pedidositens', $dados);
        return $this->db->insert_id();
    }
    
    public function deletarItem ($PedCod, $ProdCod) {
        $this->db->where('PedCod', $PedCod);
        $this->db->where('ProdCod', $ProdCod);
        $this->db->delete('pedidositens');
    }
    
    public function deletarTodos ($PedCod) {
        $this->db->where('PedCod', $PedCod);
        $this->db->delete('pedidositens');
    }
}