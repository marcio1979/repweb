<?php
defined('BASEPATH') OR exit('No direct script access allowed');
        
Class M_emails extends CI_Model
{
    
    public function total ($filtros) {
        $result = $this->listar($filtros);
        return count($result);
    }
    
    public function listar ($filtros, $ordem = null, $sort = null, $inicio = null, $limite = null)
    {
        $this->db->select('*');
        $this->db->from('emails');
        
        if (isset($inicio) && isset($limite)) {
            $this->db->limit($limite, $inicio);        
        }
        
        if (isset($ordem) && isset($sort)) {
            $this->db->order_by($ordem, $sort);
        }
        
        foreach ($filtros as $dado => $filtro) { 
            if ($filtro != '') { 
                if ($dado == 'EmaCod' || $dado == 'EmaTipo') { 
                    $this->db->where($dado, $filtro);
                } else {
                    $this->db->like($dado, $filtro);
                }
            }
        }
        
        $query = $this->db->get(); 
        return $query->result();
    }

    public function alterar ($dados)
    {
        $this->db->where('EmaCod', $dados['EmaCod']);
        $this->db->update('emails', $dados);
        return true;
    }
    
}