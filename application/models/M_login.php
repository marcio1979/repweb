<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class M_Login extends CI_Model
{
	function login($email, $senha)
    {
        $this -> db -> select('UsuCod, UsuNome, UsuNomeFantasia, UsuMaster, UsuStatus');
        $this -> db -> from('usuarios');
        $this -> db -> where('UsuEmail', $email);
        $this -> db -> where('UsuSenha', $senha);
        $this -> db -> limit(1);
         
        $query = $this -> db -> get();

        if($query -> num_rows() == 1) {
          return $query->result();
        } else {
            return false;
        }
    }
    
    function verificaEmail($email)
    {
        $this -> db -> select('UsuCod, UsuNome');
        $this -> db -> from('usuarios');
        $this -> db -> where('UsuEmail', $email);
        $this -> db -> limit(1);
         
        $query = $this -> db -> get();

        if($query -> num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    function verificaDocumento($documento)
    {
        $this -> db -> select('UsuCod, UsuNome, UsuMaster');
        $this -> db -> from('usuarios');
        $this -> db -> where('UsuDocumento', $documento);
        $this -> db -> limit(1);
         
        $query = $this -> db -> get();

        if($query -> num_rows() == 1) {
          return true;
        } else {
            return false;
        }
    }
    
    function verificaChave($chave)
    {
        $this -> db -> select('UsuCod');
        $this -> db -> from('usuarios');
        $this -> db -> where('UsuChaveSenha', $chave);
        $this -> db -> limit(1);
        $query = $this -> db -> get();
        if($query -> num_rows() == 1) {
          return $query->result();
        } else {
            return false;
        }
    }
    
    public function salvaChave ($email, $chave)
    {
        $this->db->where('UsuEmail', $email);
        $this->db->update('usuarios', array('UsuChaveSenha' => $chave));
        return true;
    }
    
    public function novaSenha ($chave, $senha)
    {
        $this->db->where('UsuChaveSenha', $chave);
        $this->db->update('usuarios', array('UsuSenha' => $senha, 'UsuChaveSenha' => NULL));
        return true;
    }
	
    public function cadastrar($dados)
    {
        $this->db->insert('usuarios', $dados);
        return $this->db->insert_id();
    }
    
    public function totalLogAcesso ($filtros) {
        $result = $this->listarLogAcesso($filtros);
        return count($result);
    }
    
    public function listarLogAcesso ($filtros, $ordem = null, $sort = null, $inicio = null, $limite = null)
    {
        $this->db->select('*');
        $this->db->from('logacesso');
        $this->db->join('usuarios', 'logacesso.UsuCod = usuarios.UsuCod', 'left');
        $this->db->join('logacessotipo', 'logacessotipo.LATCod = logacesso.LATCod', 'inner');
        
        foreach ($filtros as $dado => $filtro) {
 
            if ($filtro != '') { 
                if ($dado == 'LATCod') { 
                    $this->db->where('logacesso.LATCod', $filtro);
                } else {
                    $this->db->like($dado, $filtro);
                }
            }
        }
        
        if (isset($inicio) && isset($limite)) {
            $this->db->limit($limite, $inicio);        
        }
        
        if (isset($ordem) && isset($sort)) {
            $this->db->order_by($ordem, $sort);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    public function cadastrarLogAcesso ($dados)
    {
        $this->db->insert('logacesso', $dados);
        return $this->db->insert_id();
    }
}