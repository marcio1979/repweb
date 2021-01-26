<?php
defined('BASEPATH') OR exit('No direct script access allowed');
        
Class M_fabricantes extends CI_Model
{
    
    public function total ($filtros) {
        $result = $this->listar($filtros);
        return count($result);
    }
    
    public function listar ($filtros, $ordem = null, $sort = null, $inicio = null, $limite = null)
    {
        $this->db->select('FabCod, FabNome, FabDataCadastro, FabAtivo, FabExcluido');
        $this->db->from('fabricantes');
        
        if (isset($inicio) && isset($limite)) {
            $this->db->limit($limite, $inicio);        
        }
        
        if (isset($ordem) && isset($sort)) {
            $this->db->order_by($ordem, $sort);
        }
        
        foreach ($filtros as $dado => $filtro) { 
            if ($filtro != '') { 
                if ($dado == 'FabAtivo' || $dado == 'FabExcluido') { 
                    if ($filtro == 0 || $filtro == 1) {
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

    public function excluir ($codigo) {
        $this->db->where('FabCod', $codigo);
        $this->db->update('fabricantes', array('FabExcluido' => '1'));
        return true;
    }
    
    public function alterar ($dados)
    {
        $this->db->where('FabCod', $dados['FabCod']);
        $this->db->update('fabricantes', $dados);
        return true;
    }
    
    public function cadastrar ($data) {
        $_prepared = array();
        foreach ($data as $col => $val)
            $_prepared[$col] = $this->db->escape($val);
        $this->db->query('INSERT IGNORE INTO fabricantes ('.implode(',',array_keys($_prepared)).') VALUES('.implode(',',array_values($_prepared)).') ON DUPLICATE KEY UPDATE FabAtivo = 1, FabExcluido = 0, FabDataUpdate = \''.date('Y-m-d H:i:s').'\';');
        return $this->db->insert_id();
    }
}