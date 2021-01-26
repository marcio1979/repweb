<?php
defined('BASEPATH') OR exit('No direct script access allowed');
        
Class M_usuarios extends CI_Model
{
    
    public function total ($filtros) {
        $result = $this->listar($filtros);
        return count($result);
    }
    
    public function listar ($filtros, $ordem = null, $sort = null, $inicio = null, $limite = null)
    {
        $this->db->select("*");
        $this->db->from('usuarios');
                
        if (isset($inicio) && isset($limite)) {
            $this->db->limit($limite, $inicio);        
        }
        
        if (isset($ordem) && isset($sort)) {
            $this->db->order_by($ordem, $sort);
        }
        
        foreach ($filtros as $dado => $filtro) {
 
            if ($filtro != '') { 
                if ($dado == 'UsuStatus') { 
                    if ($filtro == 0 || $filtro == 1 || $filtro == 2) {
                        $this->db->where($dado, $filtro);
                    }
                } else {
                    $this->db->like($dado, $filtro);
                }
            }
        }
        
        $query = $this->db->get(); 
        return $query->result();
    }
    
    public function listarFornecedores ($UsuCod)
    {
        $this->db->select('fornecedores.ForCod, ForNome, ForPedidoMinimo, ForDescricao, ForLogotipo, ForFlyer, UFCondicaoPagamento');
        $this->db->from('usuarios_fornecedores');
        $this->db->join('fornecedores', 'fornecedores.ForCod = usuarios_fornecedores.ForCod', 'inner');
        $this->db->where('UsuCod', $UsuCod);
        $this->db->where('ForAtivo', '1');
        $this->db->where('ForExcluido', '0');
        $query = $this->db->get();
        return $query->result(); 
    }
    
    public function excluirFornecedores($UsuCod) {
        $this->db->where('UsuCod', $UsuCod);
        $this->db->delete('usuarios_fornecedores');
        return true;
    }
    
    public function cadastrarFornecedores($dados)
    {
        $this->db->insert('usuarios_fornecedores', $dados);
        return $this->db->insert_id();
    }

    public function alterar ($dados)
    {
        $this->db->where('UsuCod', $dados['UsuCod']);
        $this->db->update('usuarios', $dados);
        return true;
    }
    
    public function cadastrar ($dados)
    {
        $this->db->insert('usuarios', $dados);
        return $this->db->insert_id();
    }
    
}