<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class M_Configuracoes extends CI_Model
{
	function listar ()
 	{
		$this->db->select('CfgCod, CfgNomeEmpresa, CfgTelefone, CfgEmail, CfgEndereco, CfgLogo, CfgFavicon');
 		$this->db->from('configuracoes');
		$this->db->where('CfgCod', '1');
		
		$query = $this->db->get();

		if($query->num_rows() > 0) {
			$return = $query->result();
			return $return[0];
		} else {
			return false;
		}
	}
    
	function alterar ($data)
 	{
 		$this->db->where('CfgCod', '1');
		$this->db->update('configuracoes', $data);
        return true;
	}
}