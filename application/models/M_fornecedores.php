<?php
defined('BASEPATH') OR exit('No direct script access allowed');
        
Class M_fornecedores extends CI_Model
{
    
    public function total ($filtros) {
        $result = $this->listar($filtros);
        return count($result);
    }
    
    public function listar ($filtros, $ordem = null, $sort = null, $inicio = null, $limite = null)
    {
        $this->db->select('ForCod, ForNome, ForDescricao, ForLogotipo, ForFlyer, ForPedidoMinimo, ForDataCadastro, ForAtivo, ForExcluido');
        $this->db->from('fornecedores');
        
        if (isset($inicio) && isset($limite)) {
            $this->db->limit($limite, $inicio);        
        }
        
        if (isset($ordem) && isset($sort)) {
            $this->db->order_by($ordem, $sort);
        }
        
        foreach ($filtros as $dado => $filtro) { 
            if ($filtro != '') { 
                if ($dado == 'ForAtivo' || $dado == 'ForExcluido') { 
                    if ($filtro == 0 || $filtro == 1) {
                        $this->db->where($dado, $filtro);
                    }
                } elseif ($dado == 'UsuCod') {
                    $this->db->where("Exists(Select ForCod FROM usuarios_fornecedores Where usuarios_fornecedores.ForCod = fornecedores.ForCod AND usuarios_fornecedores.UsuCod = '".$filtro."')");
                } else {
                    $this->db->like($dado, $filtro);
                }
            }
        }
        
        $query = $this->db->get(); 
        return $query->result();
    }

    public function excluir ($codigo) {
        $this->db->where('ForCod', $codigo);
        $this->db->update('fornecedores', array('ForExcluido' => '1'));
        return true;
    }
    
    public function alterar ($dados)
    {
        $this->db->where('ForCod', $dados['ForCod']);
        $this->db->update('fornecedores', $dados);
        return true;
    }
    
    public function cadastrar ($data) {
        $_prepared = array();
        foreach ($data as $col => $val)
            $_prepared[$col] = $this->db->escape($val);
        $this->db->query('INSERT IGNORE INTO fornecedores ('.implode(',',array_keys($_prepared)).') VALUES('.implode(',',array_values($_prepared)).') ON DUPLICATE KEY UPDATE ForAtivo = 1, ForExcluido = 0, ForDataUpdate = \''.date('Y-m-d H:i:s').'\';');
        return $this->db->insert_id();
    }
}